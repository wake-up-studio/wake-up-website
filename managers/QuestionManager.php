<?php

class QuestionManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }

    public function findAll() : array {
        $query = $this -> db -> prepare("
                SELECT *
                FROM questions
            ");
        $query -> execute();
        $results = $query -> fetchAll(PDO::FETCH_ASSOC);
        $questions = [];
        foreach($results as $result){
            $questions[] = new Question($result["content"], $result["form_id"], $result["id"]);
        }
        return $questions;
    }

    public function findByFormId($id) : array {
        $query = $this -> db -> prepare("
                SELECT *
                FROM questions
                WHERE form_id = :form_id
            ");
        $parameters = ["form_id" => $id];
        $query -> execute($parameters);
        $results = $query -> fetchAll(PDO::FETCH_ASSOC);
        $questions = [];
        foreach($results as $result){
            $questions[] = new Question($result["content"], $result["form_id"], $result["id"]);
        }
        return $questions;
    }

    public function findOne(int $id) : ?Question{
        $query = $this -> db -> prepare("
            SELECT *
            FROM questions
            WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
        $result = $query -> fetch(PDO::FETCH_ASSOC);
        if($result){
            $question = new Question($result["content"], $result["form_id"], $result["id"]);
            return $question;
        }
        return null;
    }

    public function delete(int $id){
        $query = $this -> db -> prepare("
        DELETE FROM questions
        WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
    }

    public function create(Question $question){
        $query = $this -> db -> prepare("
        INSERT INTO questions(content, form_id)
        VALUES(:content, :form_id)
        ");
        if($question -> getFormId() !== null){
            $parameters = [
                "content" => $question->getContent(),
                "form_id" => intval($question->getFormId())
            ];
        }
        else{
            $parameters = [
                "content" => $question->getContent(),
                "form_id" => $question->getFormId()
            ];
        }

        $query -> execute($parameters);

        $id = $this -> db -> lastInsertId();
        $question->setId($id);
    }

    public function update(Question $question){
        $query = $this -> db -> prepare("
        UPDATE questions
        SET
        content = :content,
        form_id = :form_id
        WHERE id = :id");
        if($question -> getFormId() !== null){
            $parameters = [
                "content" => $question->getContent(),
                "form_id" => intval($question->getFormId()),
                "id" => $question->getId()
            ];
        }
        else{
            $parameters = [
                "content" => $question->getContent(),
                "form_id" => $question->getFormId(),
                "id" => $question->getId()
            ];
        }
        $query -> execute($parameters);
    }
}

?>
