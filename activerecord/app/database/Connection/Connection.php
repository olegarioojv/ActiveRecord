<?php

// Define o namespace da classe Connection
namespace app\database\Connection;

// Importa as classes necessárias do PDO e PDOException
use PDO;
use PDOException;

// Classe Connection para gerenciar a conexão com o banco de dados
class Connection
{
    // Propriedade estática para armazenar a instância do PDO
    private static $pdo = null;

    // Método estático para conectar ao banco de dados
    public static function connect(): PDO
    {
        try {
            // Verifica se já existe uma conexão estabelecida
            if (static::$pdo === null) {
                // Se não houver, cria uma nova conexão PDO
                static::$pdo = new PDO("mysql:host=localhost;dbname=activerecord", "root", "", [
                    // Configurações do PDO
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lança exceções em caso de erro
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // Retorna resultados como objetos
                    PDO::ATTR_EMULATE_PREPARES => false // Desabilita a emulação de prepared statements
                ]);
            }
            // Retorna a instância do PDO
            return static::$pdo;
        } catch (PDOException $e) {
            // Em caso de falha na conexão, exibe uma mensagem de erro e termina o script
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
