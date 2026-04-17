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
            $services[] = new Service($result["title"], $result["content"], DateTime::createFromFormat("Y-m-d H:i:s", $result["created_at"] ), $result["id"]);
        }
        return $services;
    }

    public function findOne(int $id) : ?Service{
        $query = $this -> db -> prepare("
            SELECT *
            FROM services
            WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
        $result = $query -> fetch(PDO::FETCH_ASSOC);
        if($result){
            $service = new Service($result["title"], $result["content"], DateTime::createFromFormat("Y-m-d H:i:s", $result["created_at"] ), $result["id"]);
            return $service;
        }
        return null;
    }

    public function delete(int $id){
        $query = $this -> db -> prepare("
        DELETE FROM services
        WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
    }

    public function create(Service $service){
        $query = $this -> db -> prepare("
        INSERT INTO services(title, content, created_at)
        VALUES(:title, :content, NOW())
        ");
        $parameters = ["title" => $service->getTitle(),
            "content" => $service->getContent()];
        $query -> execute($parameters);

        $id = $this -> db -> lastInsertId();
        $service->setId($id);
    }

    public function update(Service $service){
        $query = $this -> db -> prepare("
        UPDATE services
        SET title = :title,
        content = :content,
        created_at = :created_at
        WHERE id = :id");
        $parameters = ["title" => $service->getTitle(),
            "content" => $service->getContent(),
            "created_at" => $service->getCreatedAt() -> format("Y-m-d H:i:s"),
            "id" => $service->getId()];
        $query -> execute($parameters);
    }

}

?>
