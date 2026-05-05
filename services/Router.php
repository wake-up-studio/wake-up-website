<?php

class Router{
    public function __construct(){
        $this -> uc = new UserController();
        $this -> pc = new ProjectController();
        $this -> mc = new MediaController();
        $this -> fc = new FormController();
        $this -> sc = new ServiceController();
        $this -> qc = new QuestionController();
        $this -> rc = new RendezVousController();
        $this -> ac = new AuthController();
    }

    public function handleRequest(array $get) : void{
//        var_dump($get, $_SESSION);
//        die;

        if(isset($get["route"])){
            // ROUTER ADMIN USERS
            if($get["route"] === "listUsers"){
                $this -> uc -> list();
            }
            else if($get["route"] === "showUser" && isset($get["user_id"])){
                $this -> uc -> show($get["user_id"]);
            }
            else if($get["route"] === "createUser"){
                $this -> uc -> create();
            }
            else if($get["route"] === "checkCreateUser"){
                $this -> uc -> checkCreate();
            }
            else if($get["route"] === "deleteUser" && isset($get["user_id"])){
                $this -> uc -> delete($get["user_id"]);
            }
            else if($get["route"] === "updateUser"){
                $this -> uc -> update($get["user_id"]);
            }
            else if($get["route"] === "checkUpdateUser" && isset($get["user_id"])){
                $this -> uc -> checkUpdate($get["user_id"]);
            }

            // ROUTER ADMIN PROJECTS
            else if($get["route"] === "listProjects"){
                $this -> pc -> list();
            }
            else if($get["route"] === "showProject" && isset($get["project_id"])){
                $this -> pc -> show($get["project_id"]);
            }
            else if($get["route"] === "createProject"){
                $this -> pc -> create();
            }
            else if($get["route"] === "checkCreateProject"){
                $this -> pc -> checkCreate();
            }
            else if($get["route"] === "deleteProject" && isset($get["project_id"])){
                $this -> pc -> delete($get["project_id"]);
            }
            else if($get["route"] === "updateProject"){
                $this -> pc -> update($get["project_id"]);
            }
            else if($get["route"] === "checkUpdateProject" && isset($get["project_id"])){
                $this -> pc -> checkUpdate($get["project_id"]);
            }

            // ROUTER ADMIN MEDIAS
            else if($get["route"] === "listMedias"){
                $this -> mc -> list();
            }
            else if($get["route"] === "showMedia" && isset($get["media_id"])){
                $this -> mc -> show($get["media_id"]);
            }
            else if($get["route"] === "createMedia"){
                $this -> mc -> create();
            }
            else if($get["route"] === "checkCreateMedia"){
                $this -> mc -> checkCreate();
            }
            else if($get["route"] === "deleteMedia" && isset($get["media_id"])){
                $this -> mc -> delete($get["media_id"]);
            }
            else if($get["route"] === "updateMedia"){
                $this -> mc -> update($get["media_id"]);
            }
            else if($get["route"] === "checkUpdateMedia" && isset($get["media_id"])){
                $this -> mc -> checkUpdate($get["media_id"]);
            }

            // ROUTER ADMIN SERVICES
            else if($get["route"] === "listServices"){
                $this -> sc -> list();
            }
            else if($get["route"] === "showService" && isset($get["service_id"])){
                $this -> sc -> show($get["service_id"]);
            }
            else if($get["route"] === "createService"){
                $this -> sc -> create();
            }
            else if($get["route"] === "checkCreateService"){
                $this -> sc -> checkCreate();
            }
            else if($get["route"] === "deleteService" && isset($get["service_id"])){
                $this -> sc -> delete($get["service_id"]);
            }
            else if($get["route"] === "updateService"){
                $this -> sc -> update($get["service_id"]);
            }
            else if($get["route"] === "checkUpdateService" && isset($get["service_id"])){
                $this -> sc -> checkUpdate($get["service_id"]);
            }

            // ROUTER ADMIN FORMS
            else if($get["route"] === "listForms"){
                $this -> fc -> list();
            }
            else if($get["route"] === "showForm" && isset($get["form_id"])){
                $this -> fc -> show($get["form_id"]);
            }
            else if($get["route"] === "createForm"){
                $this -> fc -> create();
            }
            else if($get["route"] === "checkCreateForm"){
                $this -> fc -> checkCreate();
            }
            else if($get["route"] === "deleteForm" && isset($get["form_id"])){
                $this -> fc -> delete($get["form_id"]);
            }
            else if($get["route"] === "updateForm"){
                $this -> fc -> update($get["form_id"]);
            }
            else if($get["route"] === "checkUpdateForm" && isset($get["form_id"])){
                $this -> fc -> checkUpdate($get["form_id"]);
            }

            // ROUTER ADMIN QUESTIONS
            else if($get["route"] === "listQuestions"){
                $this -> qc -> list();
            }
            else if($get["route"] === "showQuestion" && isset($get["question_id"])){
                $this -> qc -> show($get["question_id"]);
            }
            else if($get["route"] === "createQuestion"){
                $this -> qc -> create();
            }
            else if($get["route"] === "checkCreateQuestion"){
                $this -> qc -> checkCreate();
            }
            else if($get["route"] === "deleteQuestion" && isset($get["question_id"])){
                $this -> qc -> delete($get["question_id"]);
            }
            else if($get["route"] === "updateQuestion"){
                $this -> qc -> update($get["question_id"]);
            }
            else if($get["route"] === "checkUpdateQuestion" && isset($get["question_id"])){
                $this -> qc -> checkUpdate($get["question_id"]);
            }

            // ROUTER ADMIN Rendez-Vous
            else if($get["route"] === "listRendezVous"){
                $this -> rc -> list();
            }
            else if($get["route"] === "showRendezVous" && isset($get["rendezVous_id"])){
                $this -> rc -> show($get["rendezVous_id"]);
            }
            else if($get["route"] === "createRendezVous"){
                $this -> rc -> create();
            }
            else if($get["route"] === "checkCreateRendezVous"){
                $this -> rc -> checkCreate();
            }
            else if($get["route"] === "deleteRendezVous" && isset($get["rendezVous_id"])){
                $this -> rc -> delete($get["rendezVous_id"]);
            }
            else if($get["route"] === "updateRendezVous"){
                $this -> rc -> update($get["rendezVous_id"]);
            }
            else if($get["route"] === "checkUpdateRendezVous" && isset($get["rendezVous_id"])){
                $this -> rc -> checkUpdate($get["rendezVous_id"]);
            }
            else if($get["route"] === "agendaAdmin"){
                $this -> rc -> showAgendaBackOffice();
            }

            //AUTHENTIFICATION
            else if($get["route"] === "authUser"){
                $this -> ac -> auth();
            }
            else if($get["route"] === "checkAuthUser"){
                $this -> ac -> checkAuth();
            }
            else if($get["route"] === "logout"){
                $this -> ac -> logout();
            }

            // ROUTER ADMIN CLIENT
            else if($get["route"] === "homeClient" && isset($_SESSION["user_id"])){
                $fm = new FormManager();
                $pm = new ProjectManager();
                $data = [
                    "user_id" => $_SESSION["user_id"],
                    "forms" => $fm -> findByUserId($_SESSION["user_id"]),
                    "projects" => $pm -> findByUserId($_SESSION["user_id"])
                ];
                $this -> ac -> homeClient($data);
            }
            else if ($get["route"] === "formHomeClient" && isset($get["form_id"])){
                $this -> fc -> homeFormClient($get["form_id"]);
            }
            else if ($get["route"] === "formClient" && isset($get["form_id"])){
                $this -> fc -> formClient($get["form_id"]);
            }
            else if ($get["route"] === "sendFormClient"){
                $data = $_POST;
                $this -> fc -> sendFormClient($data);
            }
            else if ($get["route"] === "projectClient" && isset($get["project_id"])){
                $this -> pc -> showProjectClient($get["project_id"]);
            }
            else if ($get["route"] === "agendaClient" && isset($_SESSION["user_id"])){
                $this -> rc -> showAgendaClient();
            }

            // FULLCALENDAR FETCH
            else if ($get["route"] === "giveInfoDate"){
                $this -> rc -> giveInfoDate();
            }
            else if ($get["route"] === "giveInfoTime"){
                $this -> rc -> giveInfoTime();
            }

            // ERREUR
            else{
                echo "Wow, chui où ?";
            }
        }
        else{
            $this -> ac -> auth();
        }
    }
}

?>