<?php
class RendezVousController extends AbstractController
{
    public function __construct()
    {
        $this -> rm = new RendezVousManager();
    }

// AFFICHAGE

    public function list(){
        $data = $this -> rm -> findAll();
        $this -> renderAdmin("backOffice/rendezVous/listRendezVous", $data);
    }

    public function show(int $id){
        $data = ["rendezVous" => $this -> rm -> findOne($id)];
        $this -> renderAdmin("backOffice/rendezVous/showRendezVous", $data);
    }

    public function update(int $id){
        $rendezVous = $this -> rm -> findOne($id);
        $this -> renderAdmin("backOffice/rendezVous/updateRendezVous", ["rendezVous" => $rendezVous]);
    }

    public function create(){
        $this -> renderAdmin("backOffice/rendezVous/createRendezVous", []);
    }

    public function showAgendaBackOffice(){
        $this -> renderAdmin("backOffice/rendezVous/agendaAdmin", []);
    }

    public function showAgendaClient(){
        $this -> renderAdmin("client/agenda/agendaClient", []);
    }

// LOGIQUE CUD

    public function delete(int $id){
        $this -> rm -> delete($id);
        $this -> redirect("index.php?route=listRendezVous");
    }

    public function checkUpdate(int $id){
        if (isset($_POST["date"],$_POST["motif"], $_POST["user_id"], $_POST["time"])) {
            $date = $_POST["date"]." ".$_POST["time"].":00";
            $motif = $_POST["motif"];
            $user_id = $_POST["user_id"];

            if(!empty(trim($date)) && !empty(trim($motif)) && !empty(trim($user_id))){
                $rendezVous = new RendezVous(DateTime::createFromFormat('Y-m-d H:i:s', $date), $motif, $user_id, $id);

                if($rendezVous !== null){
                    $this -> rm -> update($rendezVous);
                    unset($_SESSION["error"]);
                    $this -> redirect("index.php?route=showRendezVous&rendezVous_id=".$rendezVous -> getId());
                }
                else{
                    $_SESSION["error"] = "Oops";
                    $this -> renderAdmin("backOffice/rendezVous/updateRendezVous", []);
                }
            }
            else{
                $_SESSION["error"] = "Champs manquants";
                $this -> renderAdmin("backOffice/rendezVous/updateRendezVous", []);
            }
        }
        else{
            $_SESSION["error"] = "Champs manquants";
            $this -> renderAdmin("backOffice/rendezVous/updateRendezVous", []);
        }
    }

    public function checkCreate(){
        if (isset($_POST["date"],$_POST["motif"], $_POST["user_id"], $_POST["time"])) {
            $date = $_POST["date"]." ".$_POST["time"].":00";
            $motif = $_POST["motif"];
            $user_id = $_POST["user_id"];

            if(!empty(trim($date)) && !empty(trim($motif)) && !empty(trim($user_id))){
                $rendezVous = new RendezVous(DateTime::createFromFormat('Y-m-d H:i:s', $date), $motif, $user_id);
                $this -> rm -> create($rendezVous);
                unset($_SESSION["error"]);
                $this -> redirect("index.php?route=showRendezVous&rendezVous_id=".$rendezVous -> getId());
            }
            else{
                $_SESSION["error"] = "Champs manquants";
                $this -> renderAdmin("backOffice/rendezVous/createRendezVous", []);
            }
        }
        else{
            $_SESSION["error"] = "Champs manquants";
            $this -> renderAdmin("backOffice/rendezVous/createRendezVous", []);
        }
    }

// LOGIQUE JS CLIENT

    public function giveInfoDate(){
        if(isset($_POST) && isset($_POST["date"])){
            $date = $_POST["date"];
            require("templates/admin/client/agenda/partials/_creneaux.phtml");
        }
    }

    public function giveInfoTime(){
        if(isset($_POST) && isset($_POST["time"])){
            $time = $_POST["time"];
            require("templates/admin/client/agenda/partials/_motifs.phtml");
        }
    }
}