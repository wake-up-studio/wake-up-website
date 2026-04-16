<?php

class ServiceManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }

    public function findAll() : array {
        $query = $this -> db -> prepare("
                SELECT *
                FROM services
            ");
        $query -> execute();
        $results = $query -> fetchAll(PDO::FETCH_ASSOC);
        $services = [];
        foreach($results as $result){
            $services[] = new Service($result["title"], $result["content"], $result["created_at"], $result["id"]);
        }
        return $services;
    }

}

?>
