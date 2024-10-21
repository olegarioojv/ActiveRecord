<?php

// Define o namespace da classe User
namespace app\database\models;

// Importa a classe ActiveRecord da camada de ativação de registro
use app\database\activerecord\ActiveRecord;
// Importa a classe ActiveRecordUser, caso seja necessária (mas não está sendo utilizada aqui)
use app\database\activerecord\ActiveRecordUser;

// Declaração da classe User que estende ActiveRecord
class User extends ActiveRecord
{
    // Define o nome da tabela associada a este modelo
    protected $table = "users";
}
