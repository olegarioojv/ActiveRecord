<?php

// Carrega o autoloader do Composer, que faz o carregamento automático das classes do projeto
require "../vendor/autoload.php";

// Importa a classe FindAll e a classe User dos namespaces especificados
use app\database\activerecord\FindAll;
use app\database\models\User;

// Cria uma nova instância da classe User, que provavelmente representa um modelo de usuário no banco de dados
$user = new User();

// Executa o método 'execute' da instância de 'User', passando como argumento uma nova instância da classe FindAll,
// que provavelmente faz uma busca por todos os registros de usuários no banco de dados
var_dump($user->execute(new FindAll));
