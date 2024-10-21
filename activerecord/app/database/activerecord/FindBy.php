<?php

// Define o namespace da classe FindBy
namespace app\database\activerecord;

// Importa as interfaces que a classe FindBy implementa ou utiliza
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use Exception;
use app\database\Connection\Connection;
use Throwable;

// Classe FindBy que implementa a interface ActiveRecordExecuteInterface
class FindBy implements ActiveRecordExecuteInterface
{
    // Construtor da classe FindBy, que define o campo de busca, valor, e os campos retornados
    public function __construct(private string $field, private string $value, private string $fields = "*")
    {
    }

    // Método execute que será chamado para executar a consulta
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            // Cria a query SQL com base nos parâmetros fornecidos
            $query = $this->createQuery($activeRecordInterface);

            // Conecta ao banco de dados
            $connection = Connection::connect();

            // Prepara a query para execução
            $prepare = $connection->prepare($query);

            // Executa a consulta passando o valor do campo
            $prepare->execute([
                $this->field => $this->value
            ]);

            // Retorna um único resultado da consulta
            return $prepare->fetch();

        } catch (Throwable $throw) {
            // Captura e trata qualquer erro que ocorra durante a execução
            FormatExcetion($throw);
        }
    }

    // Método privado que cria a query SQL com base nos parâmetros passados no construtor
    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {
        // Gera a query SQL baseada no campo e valor fornecidos
        // Exemplo: "SELECT * FROM users WHERE id = :id"
        $sql = "SELECT {$this->fields} FROM {$activeRecordInterface->getTable()} WHERE {$this->field} = :{$this->field}";
        return $sql;
    }
}
