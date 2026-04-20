<?php

class UserController extends AbstractController
{

    public function __construct()
    {
        $this -> um = new UserManager();
    }

// AFFICHAGE

    public function list(){
        $data = $this -> um -> findAll();
        $this -> renderAdmin("_admin/user/listUsers", $data);
    }

    public function show(int $id){
        $data = ["user" => $this -> um -> findOne($id)];
        $this -> renderAdmin("_admin/user/showUser", $data);
    }

    public function update(int $id){
        $user = $this -> um -> findone($id);
        $this -> renderAdmin("_admin/user/updateUser", ["user" => $user]);
    }

    public function create(){
        $this -> renderAdmin("_admin/user/createUser", []);
    }

//CHECK AFFICHAGE

    public function delete(int $id){
        $this -> um -> delete($id);
        $this -> redirect("index.php");
    }

    public function checkUpdate(int $id){
        if (isset($_POST["email"],$_POST["role"])){
            $email = $_POST["email"];
            $password = $_POST["password"];
            $role = $_POST["role"];
            $created_at = $_POST["created_at"];
            $regexEmail = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9._%+-]+\.[A-Za-z]{2,}$/';

            if(preg_match($regexEmail, $_POST["email"]) && !empty(trim($password)) && !empty(trim($role))&& !empty(trim($created_at))){
                $securedPassword = password_hash($password, PASSWORD_DEFAULT);
                $user = new User($email, $securedPassword, $role, DateTime::createFromFormat('Y-m-d H:i:s', $created_at), $id);

                if($user !== null){
                    $this -> um -> update($user);
                    $data= [];
                    $this -> redirect("index.php?route=showUser&user_id=".$user -> getId());
                }
                else{
                    $data = ["error" => "Oops"];
                    $this -> renderAdmin("_admin/user/updateUser", $data);
                }
            }
            else{
                $data = ["error" => "Champs manquants"];
                $this -> renderAdmin("_admin/user/updateUser", []);
            }
        }
        else{
            $data = ["error" => "Champs manquants"];
            $this -> renderAdmin("_admin/user/updateUser", []);
        }
    }

    public function checkCreate(){
        if (isset($_POST["email"], $_POST["password"], $_POST["role"])){
            $email = $_POST["email"];
            $password = $_POST["password"];
            $role = $_POST["role"];
            $regexEmail = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9._%+-]+\.[A-Za-z]{2,}$/';

            if(preg_match($regexEmail, $_POST["email"]) && !empty(trim($password)) && !empty(trim($role))){
                $securedPassword = password_hash($password, PASSWORD_DEFAULT);
                $user = new User($email, $securedPassword, $role);
                $this -> um -> create($user);
                $data= [];
                $this -> redirect("index.php?route=showUser&user_id=".$user -> getId());
            }
            else{
                $data = ["error" => "Champs manquants"];
                $this -> renderAdmin("_admin/user/createUser", []);
            }
        }
        else{
            $data = ["error" => "Champs manquants"];
            $this -> renderAdmin("_admin/user/createUser", []);
        }
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
                            $this->renderAdmin("_admin/user/listUsers", $this->um->findAll());
                        }
                        else{
                            $user = $this -> um -> findOne($_SESSION["user_id"]);
                            $this -> renderAdmin("_client/homeClient", ["user" => $user]);
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
        unset($_SESSION["token"]);
        $this -> redirect("index.php");
    }

//CLIENT

    public function homeClient($id){
        $user = $this -> um -> findOne($id);
        $this -> renderAdmin("_client/homeClient");
    }

}