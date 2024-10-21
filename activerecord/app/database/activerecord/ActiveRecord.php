<?php

// Define o namespace para a classe ActiveRecord
namespace app\database\activerecord;

// Usa interfaces que a classe ActiveRecord irá implementar ou utilizar
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;
use ReflectionClass;

// Classe abstrata ActiveRecord que implementa a interface ActiveRecordInterface
abstract class ActiveRecord implements ActiveRecordInterface
{
    // Propriedade que irá conter o nome da tabela, inicialmente nula
    protected $table = null;

    // Array de atributos para armazenar dados dinâmicos do objeto
    protected $attributes = []; // Renomeado de $attribute para $attributes para armazenar múltiplos atributos

    // Propriedades públicas da classe (id, firstName e lastName)
    public $id; 
    public $firstName; 
    public $lastName;

    // Método construtor da classe
    public function __construct()
    {
        // Se a propriedade $table não estiver definida, gera o nome da tabela com base no nome da classe
        if (!$this->table) {
            // ReflectionClass é usada para obter o nome curto da classe e converter para minúsculas
            $this->table = strtolower((new ReflectionClass($this))->getShortName());
        }
    }

    // Retorna o nome da tabela associada a esta instância
    public function getTable()
    {
        return $this->table;
    }

    // Retorna um array com todos os atributos da classe, incluindo 'id', 'firstName', e 'lastName'
    public function getAttributes(): array
    {
        return array_merge($this->attributes, [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ]);
    }

    // Método mágico __set é chamado quando uma propriedade indefinida é definida
    public function __set($attribute, $value)
    {
        // Adiciona o par chave-valor ao array de atributos
        $this->attributes[$attribute] = $value;
    }

    // Método mágico __get é chamado quando uma propriedade indefinida é acessada
    public function __get($attribute)
    {
        // Retorna o valor do atributo se ele existir no array de atributos, ou null se não existir
        return $this->attributes[$attribute] ?? null;
    }

    // Método execute recebe uma instância de ActiveRecordExecuteInterface e executa a operação passada
    public function execute(ActiveRecordExecuteInterface $activeRecordExecuteInterface)
    {
        // Executa o método execute da interface, passando o próprio objeto ActiveRecord como parâmetro
        return $activeRecordExecuteInterface->execute($this);
    }
}
