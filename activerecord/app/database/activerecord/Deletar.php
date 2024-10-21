<?php

// Define o namespace da classe Deletar
namespace app\database\activerecord;

// Importa as interfaces que a classe Deletar irá implementar ou usar
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use app\database\Connection\Connection;
use Throwable;
use Exception;

// Classe Deletar que implementa a interface ActiveRecordExecuteInterface
class Deletar implements ActiveRecordExecuteInterface
{
    // Construtor da classe, inicializa as propriedades privadas $field (campo) e $value (valor do campo)
    public function __construct(private string $field, private string|int $value) 
    {
    }

    // Método execute, que recebe um objeto que implementa a interface ActiveRecordInterface
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            // Cria a query de delete com base nos atributos do ActiveRecord
            $query = $this->createQuery($activeRecordInterface);

            // Conecta ao banco de dados
            $connection = Connection::connect();

            // Prepara a query para ser executada
            $prepare = $connection->prepare($query);

            // Executa a query com o valor do campo passado no construtor
            $prepare->execute([
                $this->field => $this->value
            ]);

            // Retorna o número de linhas afetadas pela operação DELETE
            return $prepare->rowCount();
        } catch (Throwable $throw) {
            // Se houver uma exceção, chama a função FormatExcetion para formatar e exibir o erro
            FormatExcetion($throw);
        }
    }

    // Método privado createQuery que constrói a query SQL para deletar um registro
    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {
        // Obtém os atributos do ActiveRecord (inclui id, firstName, lastName, etc.)
        $attributes = $activeRecordInterface->getAttributes();

        // Verifica se o campo fornecido existe nos atributos
        if (!isset($attributes[$this->field])) {
            // Se o campo não for encontrado, lança uma exceção
            throw new Exception("O campo {$this->field} não foi encontrado nos atributos.");
        }

        // Cria a query SQL para deletar o registro com base no campo fornecido
        $sql = "DELETE FROM {$activeRecordInterface->getTable()} ";
        $sql .= "WHERE {$this->field} = :{$this->field}"; // Usa bind parameters (parâmetros nomeados) para evitar SQL injection

        return $sql; // Retorna a query SQL completa
    }
}
