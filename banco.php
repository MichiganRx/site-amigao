<?php

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','q1w2e3');
define('DB_DATABASE','supermercado');

class banco
{
    public $conn;
    public function __construct()
    {
        $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

        if($conn->connect_error)
        {
            die ("<h1>Erro conexão com o Banco</h1>");
        }
        //echo "Conexão com Sucesso";
        return $this->conn = $conn;
    }
}
