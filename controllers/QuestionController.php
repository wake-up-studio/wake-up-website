<?php

class QuestionController extends AbstractController
{

//AFFICHAGE ADMIN

    public function __construct()
    {
        $this -> qm = new QuestionManager();
        $this -> fm = new FormManager();
    }

    public function list(){
        $data = $this -> qm -> findAll();
        $this -> renderAdmin("_admin/question/listQuestions", $data);
    }

    public function show(int $id){
        $data = ["question" => $this -> qm -> findOne($id)];
        $this -> renderAdmin("_admin/question/showQuestion", $data);
    }

    public function update(int $id){
        $question = $this -> qm -> findOne($id);
        $this -> renderAdmin("_admin/question/updateQuestion", ["question" => $question]);
    }

    public function create(){
        $this -> renderAdmin("_admin/question/createQuestion", []);
    }

//CHECK AFFICHAGE CLIENT

    public function delete(int $id){
        $this -> qm -> delete($id);
        $this -> redirect("?route=listQuestions");
    }

    public function checkUpdate(int $id){
        if (isset($_POST["content"], $_POST["form_id"])){
            $content = $_POST["content"];
            $form_id = intval($_POST["form_id"]);

            if(!empty(trim($content)) && !empty(trim($form_id))){
                $question = new Question($content, null, $id);

                if($question !== null){
                    if($this -> fm -> findOne($form_id) !== null){
                        $question = new Question($content, $form_id, $id);
                    }
                    $this -> qm -> update($question);
                    $this -> redirect("index.php?route=showQuestion&question_id=".$question -> getId());
                }
                else{
                    $data = ["error" => "Oops", "question" => $question];
                    $this -> renderAdmin("_admin/question/updateQuestion", $data);
                }
            }
            else{
                $question = $this -> qm -> findOne($id);
                $data = ["question" => $question];
                $this -> renderAdmin("_admin/question/updateQuestion", $data);
            }
        }
        else{
            $question = $this -> qm -> findOne($id);
            $data = ["question" => $question];
            $this -> renderAdmin("_admin/question/updateQuestion", $data);
        }
    }

    public function checkCreate(){
        if (isset($_POST["content"], $_POST["form_id"])){
            $content = $_POST["content"];
            $form_id = $_POST["form_id"];

            if(!empty(trim($content)) && !empty(trim($form_id))){
                if($this -> fm -> findOne($form_id) !== null){
                    $question = new Question($content, intval($form_id));
                }
                else{
                    $question = new Question($content, null);
                }
                $this -> qm -> create($question);
                $this -> redirect("index.php?route=showQuestion&question_id=".$question -> getId());
            }
            else{
                $this -> renderAdmin("_admin/question/createQuestion", []);
            }
        }
        else{
            $this -> renderAdmin("_admin/question/createQuestion",[]);
        }
    }

//AFFICHAGE CLIENT


}