<?php 
namespace Database;

class Connection
{
    static public $instance;

    private function __construct(){}

    static public function getInstance()
    {
        if(!self::$instance) {
            //Criar uma instância de PDO(Conexão com banco)    
            $pdo = new \PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            self::$instance = $pdo;
        }

        return self::$instance;
    }
}