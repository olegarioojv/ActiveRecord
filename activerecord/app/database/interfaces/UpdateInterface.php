<?php

// Define o namespace da interface UpdateInterface
namespace app\database\interfaces;

// Declaração da interface UpdateInterface
interface UpdateInterface 
{
    // Método que deve ser implementado para atualizar um registro
    public function update(ActiveRecordInterface $activeRecordInterface);
}
