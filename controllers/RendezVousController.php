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
        $events = $this -> rm -> findAll();
        $eventStr = null;
        foreach($events as $event){
            $title = $event -> getMotif();
            $date = $event -> getDate() -> format("Y-m-d");
            $start_time = $event -> getStartingTime() -> format("H:i:s");
            $start = $date."T".$start_time."+0200";
            $end_time = $event -> getEndingTime() -> format("H:i:s");
            $end = $date."T".$end_time."+0200";
            $eventStr .= "{title: '$title', start: '$start', end: '$end', allDay: 'false'},";
        }
        $eventStr = rtrim($eventStr, ",");
        $eventsJSON = json_encode($eventStr);
//        var_dump($eventsJSON);
        $this -> renderAdmin("backOffice/rendezVous/agendaAdmin", ["events" => $eventsJSON]);
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
        if (isset($_POST["date"],$_POST["motif"], $_POST["user_id"], $_POST["time"])){
            $date = $_POST["date"];
            $starting_time = $_POST["time"].":00";
            $ending_time = $_POST["time"]->DateInterval::createFromDateString("90 i");
            $motif = $_POST["motif"];
            $user_id = $_POST["user_id"];

            if(!empty(trim($date)) && !empty(trim($motif)) && !empty(trim($user_id))){
                $rendezVous = new RendezVous(DateTime::createFromFormat('Y-m-d H:i:s', $date), DateTime::createFromFormat('H:i:s', $starting_time),
                    DateTime::createFromFormat('H:i:s', $ending_time), $motif, $user_id, $id);

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
            $date = $_POST["date"];
            $starting_time = $_POST["time"];
            $dateTime = new DateTime($_POST["time"]);
            $ending_time = $dateTime->add(DateInterval::createFromDateString("90 minutes"));
            $motif = $_POST["motif"];
            $user_id = $_POST["user_id"];

            if(!empty(trim($date)) && !empty(trim($motif)) && !empty(trim($starting_time)) && !empty(trim($user_id))){
                $rendezVous = new RendezVous(DateTime::createFromFormat('Y-m-d', $date), DateTime::createFromFormat('H:i:s', $starting_time),
                    $ending_time, $motif, $user_id);
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

    public function renderDate() {
        if (isset($_GET) && isset($_GET["date"])) {
            $date = $_GET["date"];
            $rendezVousObjects = $this->rm->findByDate($date);
            $times = [];
            foreach ($rendezVousObjects as $rendezVous) {
                $times[] = $rendezVous->getStartingTime()->format('H:i:s');
            }
            $dateTime = new DateTime($date);
            $date = $dateTime->format("d / m / Y");

            if(count($times) === 4){
                $message = "Plus de créneaux disponibles pour ce jour";
            }

            if ($times === []) {
                $creneaux = ["09:30:00" => "9:30 - 11:00", "11:00:00" => "11:00 - 12:30", "14:30:00" => "14:30 - 16:00", "16:00:00" => "16:00 - 17:30"];
                require("templates/admin/client/agenda/partials/_creneaux.phtml");
            } else {
                $creneaux = ["09:30:00" => "9:30 - 11:00", "11:00:00" => "11:00 - 12:30", "14:30:00" => "14:30 - 16:00", "16:00:00" => "16:00 - 17:30"];
                foreach ($creneaux as $key => $creneau) {
                    if (in_array($key, $times)) {
                        unset($creneaux[$key]);
                    }
                }
                require("templates/admin/client/agenda/partials/_creneaux.phtml");
            }
        }
    }

    public function renderTime(){
        if(isset($_GET) && isset($_GET["time"])){
            $time = $_GET["time"];
            require("templates/admin/client/agenda/partials/_motifs.phtml");
        }
    }

    public function checkCreateRendezVousClient($data){
        if (isset($_POST["date"],$_POST["motif"], $_SESSION["user_id"], $_POST["time"])) {
            $date = $_POST["date"];
            $starting_time = $_POST["time"];
            $dateTime = new DateTime($_POST["time"]);
            $ending_time = $dateTime->add(DateInterval::createFromDateString("90 minutes"));
            $motif = $_POST["motif"];
            $user_id = $_SESSION["user_id"];

            if(!empty(trim($date)) && !empty(trim($motif)) && !empty(trim($starting_time)) && !empty(trim($user_id))){
                $rendezVous = new RendezVous(DateTime::createFromFormat('Y-m-d', $date), DateTime::createFromFormat('H:i:s', $starting_time),
                    $ending_time, $motif, $user_id);
                $this -> rm -> create($rendezVous);
                $dateTime = new DateTime($date);
                $dateStr = $dateTime->format("d / m / Y");;
                $_SESSION["flash_message"] = "Rendez-Vous pris avec succès pour le ".$dateStr." à ".$starting_time;
                unset($_SESSION["error"]);
            }
            else{
                $_SESSION["error"] = "Champs vides";
                $this -> renderAdmin("client/agenda/agendaClient", []);
            }
        }
        else{
            $_SESSION["error"] = "POST ne passe pas";
            $this -> renderAdmin("client/agenda/agendaClient", []);
        }
    }
}