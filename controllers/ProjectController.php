<?php

class ProjectController extends AbstractController
{

//AFFICHAGE ADMIN

    public function __construct()
    {
        $this -> pm = new ProjectManager();
        $this -> um = new UserManager();
    }

    public function list(){
        $data = $this -> pm -> findAll();
        $this -> renderAdmin("backOffice/project/listProjects", $data);
    }

    public function show(int $id){
        $data = ["project" => $this -> pm -> findOne($id)];
        $this -> renderAdmin("backOffice/project/showProject", $data);
    }

    public function update(int $id){
        $project = $this -> pm -> findOne($id);
        $this -> renderAdmin("backOffice/project/updateProject", ["project" => $project]);
    }

    public function create(){
        $this -> renderAdmin("backOffice/project/createProject", []);
    }

//CHECK AFFICHAGE ADMIN

    public function delete(int $id){
        $this -> pm -> delete($id);
        $this -> redirect("?route=listProjects");
    }

    public function checkUpdate(int $id){
        if (isset($_POST["title"], $_POST["content"], $_POST["user_id"])){
            $title = $_POST["title"];
            $content = $_POST["content"];
            $user_id = $_POST["user_id"];
            $created_at = $_POST["created_at"];

            if(!empty(trim($title)) && !empty(trim($content))){
                $project = new Project($title, $content, intval($user_id), DateTime::createFromFormat("Y-m-d H:i:s", $created_at), $id);

                if($project !== null){
                    if($this -> um -> findOne($user_id) === null){
                        $project = new Project($title, $content, null, DateTime::createFromFormat("Y-m-d H:i:s", $created_at), $id);
                    }
                    $this -> pm -> update($project);
                    $this -> redirect("index.php?route=showProject&project_id=".$project -> getId());
                }
                else{
                    $data = ["error" => "Oops", "project" => $project];
                    $this -> renderAdmin("backOffice/project/updateProject", $data);
                }
            }
            else{
                $project = $this -> pm -> findOne($id);
                $data = ["project" => $project];
                $this -> renderAdmin("backOffice/project/updateProject", $data);
            }
        }
        else{
            $project = $this -> pm -> findOne($id);
            $data = ["project" => $project];
            $this -> renderAdmin("backOffice/project/updateProject", $data);
        }
    }

    public function checkCreate(){
        if (isset($_POST["title"], $_POST["content"], $_POST["user_id"])){
            $title = $_POST["title"];
            $content = $_POST["content"];
            $user_id = $_POST["user_id"];

            if(!empty(trim($title)) && !empty(trim($content))){
                if($this -> um -> findOne($user_id) === null){
                    $project = new Project($title, $content, null,);
                }
                else if(!empty(trim($user_id))){
                    $project = new Project($title, $content, $user_id);
                }
                $this -> pm -> create($project);
                $data= [];
                $this -> redirect("index.php?route=showProject&project_id=".$project -> getId());
            }
            else{
                $data = ["error" => "Champs manquants"];
                $this -> renderAdmin("backOffice/project/createProject", []);
            }
        }
        else{
            $data = ["error" => "Champs manquants"];
            $this -> renderAdmin("backOffice/project/createProject",[]);
        }
    }

//AFFICHAGE CLIENT

public function showProjectClient(int $id){
    $data = ["project" => $this -> pm -> findOne($id)];
    $this -> renderAdmin("client/projectClient", $data);
}

}