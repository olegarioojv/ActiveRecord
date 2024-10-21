<?php

// Define o namespace da classe Insert
namespace app\database\activerecord;

// Importa as interfaces necessárias e a conexão com o banco de dados
use app\database\interfaces\ActiveRecordInterface;
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\Connection\Connection;
use Throwable;

// Classe Insert que implementa a interface ActiveRecordExecuteInterface
class Insert implements ActiveRecordExecuteInterface
{
    // Método execute, que será chamado para realizar a inserção no banco de dados
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            // Cria a query de inserção usando o método createQuery
            $query = $this->createQuery($activeRecordInterface);

            // Conecta ao banco de dados
            $connection = Connection::connect();

            // Prepara a query SQL para execução
            $prepare = $connection->prepare($query);

            // Executa a query com os atributos do objeto e retorna o resultado da execução
            return $prepare->execute($activeRecordInterface->getAttributes());  
        } catch (Throwable $throw) {
            // Trata qualquer exceção que ocorra durante a execução
            FormatExcetion($throw);
        }
    }

    // Método privado createQuery, que constrói a query SQL de inserção
    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {
        // Exemplo de query gerada: 
        // "INSERT INTO users (firstName, lastName) VALUES (:firstName, :lastName)"

        // Inicia a query SQL de inserção
        $sql = "INSERT INTO {$activeRecordInterface->getTable()}(";

        // Adiciona os campos (nomes das colunas) separados por vírgula
        $sql .= implode(", ", array_keys($activeRecordInterface->getAttributes())) . ") VALUES(";

        // Adiciona os valores dos campos (usando placeholders com ":")
        $sql .= ":" . implode(", :", array_keys($activeRecordInterface->getAttributes())) . ")";

        // Retorna a query SQL completa
        return $sql;
    }
}
