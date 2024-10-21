<?php

// Define o namespace da classe FindAll
namespace app\database\activerecord;

// Importa as interfaces que a classe FindAll implementa ou utiliza
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use Exception;
use Throwable;
use app\database\Connection\Connection;

// Classe FindAll que implementa a interface ActiveRecordExecuteInterface
class FindAll implements ActiveRecordExecuteInterface
{
    // Construtor da classe FindAll
    public function __construct (
        private array $where = [], // Condições de consulta (ex.: ["id" => 1])
        private string|int $limit = "", // Limite de resultados
        private string|int $offset = "", // Deslocamento dos resultados
        private string|int $fields = "*", // Campos que serão retornados, por padrão "*"
    ) {}

    // Método execute, que será chamado para executar a consulta
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            // Cria a query SQL com base nos parâmetros fornecidos
            $query = $this->createQuery($activeRecordInterface);

            // Conecta ao banco de dados
            $connection = Connection::connect();

            // Prepara a query para execução
            $prepare = $connection->prepare($query);

            // Executa a consulta com os parâmetros da cláusula WHERE
            $prepare->execute($this->where);

            // Retorna os resultados da consulta
            return $prepare->fetchAll();
            
        } catch (Throwable $throw) {
            // Captura e trata qualquer erro que ocorra durante a execução
            FormatExcetion($throw);
        }
    }

    // Método privado que cria a query SQL com base nos parâmetros passados no construtor
    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {
        // Verifica se o array where contém mais de um índice, o que não é permitido aqui
        if (count($this->where) > 1) {
            throw new Exception("No where só pode passar um índice");
        }

        // Pega as chaves do array where (ex.: ["id" => 1] -> "id")
        $where = array_keys($this->where);

        // Inicia a query SQL com os campos e a tabela
        $sql = "SELECT {$this->fields} FROM {$activeRecordInterface->getTable()}";

        // Adiciona a cláusula WHERE, se o array where não estiver vazio
        $sql .= (!$this->where) ? "" : " WHERE {$where[0]} = :{$where[0]}";

        // Adiciona a cláusula LIMIT, se o limite foi definido
        $sql .= (!$this->limit) ? "" : " LIMIT {$this->limit}";

        // Adiciona a cláusula OFFSET, se o deslocamento foi definido
        $sql .= ($this->offset != "") ? " OFFSET {$this->offset}" : "";

        // Retorna a query SQL completa
        return $sql;
    }
}
