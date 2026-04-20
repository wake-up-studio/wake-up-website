<?php

class FormController extends AbstractController
{

    public function __construct()
    {
        $this -> fm = new FormManager();
        $this -> um = new UserManager();
    }

    public function list(){
        $data = $this -> fm -> findAll();
        $this -> renderAdmin("_admin/form/listForms", $data);
    }

    public function show(int $id){
        $data = ["form" => $this -> fm -> findOne($id)];
        $this -> renderAdmin("_admin/form/showForm", $data);
    }

    public function update(int $id){
        $form = $this -> fm -> findOne($id);
        $this -> renderAdmin("_admin/form/updateForm", ["form" => $form]);
    }

    public function create(){
        $this -> renderAdmin("_admin/form/createForm", []);
    }

    //n'affiche rien

    public function delete(int $id){
        $this -> fm -> delete($id);
        $this -> redirect("?route=listForms");
    }

    public function checkUpdate(int $id){
        if (isset($_POST["title"], $_POST["content"], $_POST["user_id"])){
            $title = $_POST["title"];
            $content = $_POST["content"];
            $user_id = intval($_POST["user_id"]);
            $created_at = $_POST["created_at"];

            if(!empty(trim($title)) && !empty(trim($content))){
                $form = new Form($title, $content, null, DateTime::createFromFormat("Y-m-d H:i:s", $created_at), $id);

                if($form !== null){
                    if($this -> um -> findOne($user_id) !== null){
                        $form = new Form($title, $content, $user_id, DateTime::createFromFormat("Y-m-d H:i:s", $created_at), $id);
                    }
                    $this -> fm -> update($form);
                    $this -> redirect("index.php?route=showForm&form_id=".$form -> getId());
                }
                else{
                    $data = ["error" => "Oops", "form" => $form];
                    $this -> renderAdmin("_admin/form/updateForm", $data);
                }
            }
            else{
                $form = $this -> fm -> findOne($id);
                $data = ["form" => $form];
                $this -> renderAdmin("_admin/form/updateForm", $data);
            }
        }
        else{
            $form = $this -> fm -> findOne($id);
            $data = ["form" => $form];
            $this -> renderAdmin("_admin/form/updateForm", $data);
        }
    }

    public function checkCreate(){
        if (isset($_POST["title"], $_POST["content"], $_POST["user_id"])){
            $title = $_POST["title"];
            $content = $_POST["content"];
            $user_id = $_POST["user_id"];

            if(!empty(trim($title)) && !empty(trim($content)) && !empty(trim($user_id))){
                if($this -> um -> findOne($user_id) !== null){
                    $form = new Form($title, $content, intval($user_id));
                }
                else{
                    $form = new Form($title, $content, null);
                }
                $this -> fm -> create($form);
                $this -> redirect("index.php?route=showForm&form_id=".$form -> getId());
            }
            else{
                $this -> renderAdmin("_admin/form/createForm", []);
            }
        }
        else{
            $this -> renderAdmin("_admin/form/createForm",[]);
        }
    }

}