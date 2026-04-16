<?php

class Router{
    public function __construct(){
        $this -> uc = new UserController();
        $this -> pc = new ProjectController();
        $this -> fc = new FormController();
        $this -> sc = new ServiceController();
    }

    public function handleRequest(array $get) : void{
        if(isset($get["route"])){
            // ROUTER ADMIN USERS
            if($get["route"] == "listUsers"){
                $this -> uc -> list();
            }
            else if($get["route"] == "showUser" && isset($get["user_id"])){
                $this -> uc -> show($get["user_id"]);
            }
            else if($get["route"] == "createUser"){
                $this -> uc -> create();
            }
            else if($get["route"] == "checkCreateUser"){
                $this -> uc -> checkCreate();
            }
            else if($get["route"] == "deleteUser" && isset($get["user_id"])){
                $this -> uc -> delete($get["user_id"]);
            }
            else if($get["route"] == "updateUser"){
                $this -> uc -> update($get["user_id"]);
            }
            else if($get["route"] == "checkUpdateUser" && isset($get["user_id"])){
                $this -> uc -> checkUpdate($get["user_id"]);
            }

            // ROUTER ADMIN PROJECTS
            else if($get["route"] == "listProjects"){
                $this -> pc -> list();
            }
            else if($get["route"] == "showProject" && isset($get["project_id"])){
                $this -> pc -> show($get["project_id"]);
            }
            else if($get["route"] == "createProject"){
                $this -> pc -> create();
            }
            else if($get["route"] == "checkCreateProject"){
                $this -> pc -> checkCreate();
            }
            else if($get["route"] == "deleteProject" && isset($get["project_id"])){
                $this -> pc -> delete($get["project_id"]);
            }
            else if($get["route"] == "updateProject"){
                $this -> pc -> update($get["project_id"]);
            }
            else if($get["route"] == "checkUpdateProject" && isset($get["project_id"])){
                $this -> pc -> checkUpdate($get["project_id"]);
            }

            // ROUTER ADMIN SERVICES
            else if($get["route"] == "listServices"){
                $this -> sc -> list();
            }

            // ROUTER ADMIN FORMS
            else if($get["route"] == "listForms"){
                $this -> fc -> list();
            }

            // ERREUR
            else{
                echo "Wow, chui où ?";
            }
        }
        else{
            $this -> uc -> list();
        }
    }
}

?>