<?php

// Define o namespace da interface ActiveRecordExecuteInterface
namespace app\database\interfaces;

// Declaração da interface ActiveRecordExecuteInterface
interface ActiveRecordExecuteInterface
{
    // Método que deve ser implementado pelas classes que utilizam esta interface
    public function execute(ActiveRecordInterface $activeRecordInterface);
}
