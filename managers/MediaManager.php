<?php

class MediaManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }

    public function findAll() : array {
        $query = $this -> db -> prepare("
                SELECT *
                FROM medias
            ");
        $query -> execute();
        $results = $query -> fetchAll(PDO::FETCH_ASSOC);
        $medias = [];
        foreach($results as $result){
            $medias[] = new Media($result["alt"], $result["url"], $result["id"]);
        }
        return $medias;
    }

    public function findOne(int $id) : ?Media{
        $query = $this -> db -> prepare("
            SELECT *
            FROM medias
            WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
        $result = $query -> fetch(PDO::FETCH_ASSOC);
        if($result){
            $media = new Media($result["alt"], $result["url"], $result["id"]);
            return $media;
        }
        return null;
    }

    public function delete(int $id){
        $query = $this -> db -> prepare("
        DELETE FROM medias
        WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
    }

    public function create(Media $media){
        $query = $this -> db -> prepare("
        INSERT INTO medias
        (alt, url)
        VALUES (:alt, :url)
        ");
        $parameters = [
            "alt" => $media->getAlt(),
            "url" => $media->getUrl()];
        $query -> execute($parameters);
        $id = $this -> db -> lastInsertId();
        $media->setId($id);
    }

    public function update(Media $media){
        $query = $this -> db -> prepare("
        UPDATE medias
        SET alt = :alt,
            url = :url
            WHERE id = :id
            ");
        $parameters = [
            "alt" => $media->getAlt(),
            "url" => $media->getUrl(),
            "id" => $media->getId()];
        $query -> execute($parameters);
    }

}

?>
