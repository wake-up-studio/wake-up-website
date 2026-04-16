<?php
abstract class AbstractManager{
    protected PDO $db;

    public function __construct()
    {
        $host = "db.3wa.io";
        $port = "3306";
        $dbname = "gurvanleroy_wake_up";
        $connexionString = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

        $user = "gurvanleroy";
        $password = "2d829f3ed3cc9932b6d2f2c9c09fe64c";

        $this->db = new PDO(
            $connexionString,
            $user,
            $password
        );
    }
}
?>
