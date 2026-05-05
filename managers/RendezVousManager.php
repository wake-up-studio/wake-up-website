<?php

class RendezVousManager extends AbstractManager
{

    public function __construct()
    {
        parent::__construct();
    }

    public function findAll() : array {
        $query = $this -> db -> prepare("
                SELECT rendez_vous.*
                FROM rendez_vous
            ");
        $query -> execute();
        $results = $query -> fetchAll(PDO::FETCH_ASSOC);
        $rendezVous = [];
        foreach($results as $result){
            $rendezVous[] = new RendezVous(DateTime::createFromFormat("Y-m-d H:i:s", $result["date"] ), $result["motif"], $result["user_id"] , $result["id"]);
        }
        return $rendezVous;
    }

    public function findOne(int $id) : ?RendezVous{
        $query = $this -> db -> prepare("
            SELECT *
            FROM rendez_vous
            WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
        $result = $query -> fetch(PDO::FETCH_ASSOC);
        if($result){
            $rendezVous = new RendezVous(DateTime::createFromFormat("Y-m-d H:i:s", $result["date"] ), $result["motif"], $result["user_id"] , $result["id"]);
            return $rendezVous;
        }
        return null;
    }

    public function delete(int $id){
        $query = $this -> db -> prepare("
        DELETE FROM rendez_vous
        WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
    }

    public function create(RendezVous $rendezVous){
        $query = $this -> db -> prepare("
        INSERT INTO rendez_vous(date, motif, user_id)
        VALUES(:date, :motif, :user_id)
        ");
        $parameters = ["date" => $rendezVous->getDate()-> format("Y-m-d H:i:s"),
            "motif" => $rendezVous->getMotif(),
            "user_id" => $rendezVous->getUserId()];
        $query -> execute($parameters);

        $id = $this -> db -> lastInsertId();
        $rendezVous->setId($id);
    }

    public function update(RendezVous $rendezVous){
        $query = $this -> db -> prepare("
        UPDATE rendez_vous
        SET date = :date,
        motif = :motif,
        user_id = :user_id
        WHERE id = :id");
        $parameters = ["date" => $rendezVous->getDate() -> format("Y-m-d H:i:s"),
            "motif" => $rendezVous->getMotif(),
            "user_id" => $rendezVous->getUserId(),
            "id" => $rendezVous->getId()];
        $query -> execute($parameters);
    }

}