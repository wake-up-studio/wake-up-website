<?php

class AuthController extends AbstractController
{
    public function __construct()
    {
        $this -> um = new UserManager();
    }
//AUTHENTIFICATION

    public function auth(){
        $this -> renderFront("auth/authUser", []);
    }

    public function checkAuth() {
        if (isset($_POST["email"], $_POST["password"])) {
            $email = $_POST["email"];
            $chars_email = htmlspecialchars($_POST["email"]);
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            if (!empty(trim($chars_email)) && !empty(trim($password))) {
                $user = $this->um->findByEmail($email);

                if ($user !== null) {
                    if (password_verify($_POST["password"], $user->getPassword())) {
                        unset($_SESSION["error"], $_SESSION["email"]);
                        $_SESSION["user_id"] = $user -> getId();
                        $_SESSION["role"] = $user -> getRole();

                        if($_SESSION["role"] == "admin"){
                            $this->renderAdmin("backOffice/rendezVous/agendaAdmin", $this->um->findAll());
                        }
                        else{
                            $this -> redirect("index.php?route=homeClient");
                        }
                    } else {
                        $_SESSION["error"] = "Mot de passe incorrect";
                        $_SESSION["email"] = $chars_email;
                        $this->renderFront("auth/authUser", $_SESSION);
                    }
                } else {
                    $_SESSION["error"] = "Email incorrect";
                    $this->renderFront("auth/authUser", $_SESSION);
                }
            } else {
                $_SESSION["error"] = "Champs manquants";
                $this->renderFront("auth/authUser", $_SESSION);
            }
        }
    }

    public function logout(){
        unset($_SESSION["id"], $_SESSION["user_id"], $_SESSION["role"]);
        $this -> redirect("index.php");
    }

//CLIENT

    public function homeClient(array $data){
        $this -> renderAdmin("client/homeClient", $data);
    }
}