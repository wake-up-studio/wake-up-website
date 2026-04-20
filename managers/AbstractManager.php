<?php
abstract class AbstractManager{
    protected PDO $db;

    public function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $port = $_ENV["DB_PORT"];
        $dbname = $_ENV["DB_NAME"];
        $connexionString = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

        $user = $_ENV["DB_USER"];
        $password = $_ENV["DB_PASS"];

        $this->db = new PDO(
            $connexionString,
            $user,
            $password
        );
    }
}
?>
