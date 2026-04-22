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
            $forms[] = new Form($result["title"], $result["content"], $result["user_id"], DateTime::createFromFormat("Y-m-d H:i:s", $result["created_at"] ), $result["id"]);
        }
        return $forms;
    }

    public function findOne(int $id) : ?Form{
        $query = $this -> db -> prepare("
            SELECT *
            FROM forms
            WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
        $result = $query -> fetch(PDO::FETCH_ASSOC);
        if($result){
            $form = new Form($result["title"], $result["content"], $result["user_id"], DateTime::createFromFormat("Y-m-d H:i:s", $result["created_at"] ), $result["id"]);
            return $form;
        }
        return null;
    }

    public function findByUserId(int $id) : ?array{
        $query = $this -> db -> prepare("
            SELECT *
            FROM forms
            WHERE user_id = :user_id
        ");
        $parameters = ["user_id" => $id];
        $query -> execute($parameters);
        $results = $query -> fetchAll(PDO::FETCH_ASSOC);
        $forms = [];
        foreach($results as $result){
            $forms[] = new Form($result["title"], $result["content"], $result["user_id"], DateTime::createFromFormat("Y-m-d H:i:s", $result["created_at"] ), $result["id"]);;
        }
        if(count($forms) != 0){
            return $forms;
        }
        return null;
    }

    public function delete(int $id){
        $query = $this -> db -> prepare("
        DELETE FROM forms
        WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
    }

    public function create(Form $form){
        $query = $this -> db -> prepare("
        INSERT INTO forms(title, content, user_id, created_at)
        VALUES(:title, :content, :user_id, NOW())
        ");
        if($form -> getUserId() !== null){
            $parameters = ["title" => $form->getTitle(),
                "content" => $form->getContent(),
                "user_id" => intval($form->getUserId())
            ];
        }
        else{
            $parameters = ["title" => $form->getTitle(),
                "content" => $form->getContent(),
                "user_id" => $form->getUserId()
            ];
        }

        $query -> execute($parameters);

        $id = $this -> db -> lastInsertId();
        $form->setId($id);
    }

    public function update(Form $form){
        $query = $this -> db -> prepare("
        UPDATE forms
        SET title = :title,
        content = :content,
        created_at = :created_at,
        user_id = :user_id
        WHERE id = :id");
        if($form -> getUserId() !== null){
            $parameters = ["title" => $form->getTitle(),
                "content" => $form->getContent(),
                "created_at" => $form->getCreatedAt() -> format("Y-m-d H:i:s"),
                "user_id" => intval($form->getUserId()),
                "id" => $form->getId()
            ];
        }
        else{
            $parameters = ["title" => $form->getTitle(),
                "content" => $form->getContent(),
                "created_at" => $form->getCreatedAt() -> format("Y-m-d H:i:s"),
                "user_id" => $form->getUserId(),
                "id" => $form->getId()
            ];
        }
        $query -> execute($parameters);
    }
}

?>
