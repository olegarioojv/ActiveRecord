<?php

// Define o namespace da classe Find
namespace app\database\activerecord;

// Importa as interfaces que a classe Find irá implementar ou utilizar
use app\database\interfaces\ActiveRecordExecuteInterface;
use app\database\interfaces\ActiveRecordInterface;

// Classe Find que implementa a interface ActiveRecordExecuteInterface
class Find implements ActiveRecordExecuteInterface
{
    // Método execute, que recebe um objeto que implementa a interface ActiveRecordInterface
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        // Exibe os atributos do objeto ActiveRecord passado como parâmetro
        // O método getAttributes retorna um array com os atributos como 'id', 'firstName', 'lastName', etc.
        var_dump($activeRecordInterface->getAttributes());
    }
}
