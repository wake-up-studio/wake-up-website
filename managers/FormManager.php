<?php

class FormManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }

    public function findAll() : array {
        $query = $this -> db -> prepare("
                SELECT *
                FROM forms
            ");
        $query -> execute();
        $results = $query -> fetchAll(PDO::FETCH_ASSOC);
        $forms = [];
        foreach($results as $result){
            $forms[] = new Form($result["user_id"], $result["content"], $result["created_at"], $result["id"]);
        }
        return $forms;
    }

}

?>
