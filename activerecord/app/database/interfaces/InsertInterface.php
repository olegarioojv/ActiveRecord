<?php

// Define o namespace da interface InsertInterface
namespace app\database\interfaces;

// Declaração da interface InsertInterface
interface InsertInterface
{
    // Método que deve ser implementado para inserir um registro
    public function insert(ActiveRecordInterface $activeRecordInterface);
}
