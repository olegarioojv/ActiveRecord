<?php

// Define o namespace da classe Update
namespace app\database\activerecord;

// Importa as interfaces necessárias e a conexão com o banco de dados
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use app\database\Connection\Connection;
use Throwable;

// Classe Update que implementa a interface ActiveRecordExecuteInterface
class Update implements ActiveRecordExecuteInterface
{
    // Construtor da classe Update, que recebe o campo e o valor a serem atualizados
    public function __construct(private string $field, private string|int $value)
    {
    }

    // Método execute, que será chamado para realizar a atualização no banco de dados
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            // Cria a consulta de update usando o método createQuery
            $query = $this->createQuery($activeRecordInterface);
            $connection = Connection::connect();

            // Pega os atributos do ActiveRecord (incluindo o 'id')
            $attributes = $activeRecordInterface->getAttributes();

            // Verifica se o ID está presente nos atributos
            if (!isset($attributes['id'])) {
                throw new \Exception("O ID não foi fornecido para o update.");
            }

            // Adiciona o campo e valor que será atualizado
            $attributes = array_merge($attributes, [
                $this->field => $this->value
            ]);

            // Prepara a consulta SQL para execução
            $prepare = $connection->prepare($query);
            // Executa a consulta com os atributos, incluindo o ID
            $prepare->execute($attributes);

            // Retorna o número de linhas afetadas pela atualização
            return $prepare->rowCount(); 
        } catch (Throwable $throw) {
            // Formata a exceção em caso de erro
            FormatExcetion(throw: $throw);
        }
    }

    // Método privado que cria a query SQL de atualização
    private function createQuery(ActiveRecordInterface $activeRecordInterface): string
    {
        // Pega os atributos do ActiveRecord (incluindo o 'id')
        $attributes = $activeRecordInterface->getAttributes();

        // Verifica se o ID está presente nos atributos
        if (!array_key_exists("id", $attributes)) {
            throw new \Exception("O campo id deve ser passado para o update.");
        }

        // Constrói a SQL de UPDATE com SET (excluindo o campo 'id') e WHERE 'id'
        $sql = "UPDATE {$activeRecordInterface->getTable()} SET ";
        $setClauses = [];

        // Cria as cláusulas para os campos a serem atualizados
        foreach ($attributes as $key => $value) {
            if ($key !== 'id') { // Ignora o ID na cláusula SET
                $setClauses[] = "{$key} = :{$key}";
            }
        }

        // Verifica se há campos para atualizar
        if (empty($setClauses)) {
            throw new \Exception("Não há campos para atualizar.");
        }

        // Junta todas as cláusulas SET
        $sql .= implode(", ", $setClauses); 
        // Adiciona a condição de WHERE pelo ID
        $sql .= " WHERE id = :id"; 

        return $sql;
    }
}
