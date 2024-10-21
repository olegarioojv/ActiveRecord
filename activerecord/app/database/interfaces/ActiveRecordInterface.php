<?php 

// Define o namespace da interface ActiveRecordInterface
namespace app\database\interfaces;

// Declaração da interface ActiveRecordInterface
interface ActiveRecordInterface
{
    // Método para executar operações de ActiveRecord
    public function execute(ActiveRecordExecuteInterface $activeRecordExecuteInterface);
    
    // Método mágico para definir um atributo
    public function __set($attribute, $value);
    
    // Método mágico para obter um atributo
    public function __get($attribute);

    // Método para obter o nome da tabela associada ao ActiveRecord
    public function getTable();
    
    // Método para obter os atributos do ActiveRecord
    public function getAttributes();
}
