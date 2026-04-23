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
        $this -> redirect("index.php?route=listUsers");
    }

    public function checkUpdate(int $id){
        if(isset($_POST["password"], $_POST["checkPassword"])){
            $password = $_POST["password"];
            $checkPassword = $_POST["checkPassword"];

            if(!empty(trim($password)) && !empty(trim($checkPassword))) {
                if ($password === $checkPassword) {
                    $user = $this->um->findOne($id);
                    if ($user !== null) {
                        $securedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $user->setPassword($securedPassword);
                        unset($_SESSION["error"]);
                        $this->redirect("index.php?route=showUser&user_id=" . $user->getId());
                    } else {
                        $_SESSION["error"] = "Oops";
                        $this -> redirect("index.php?route=updateUser&user_id=" . $id);
                    }
                } else {
                    $_SESSION["error"] = "Les mots de passe ne correspondent pas !";
                    $this -> redirect("index.php?route=updateUser&user_id=" . $id);
                }
            }
            else{
                $_SESSION["error"] = "Champs manquants";
                $this -> redirect("index.php?route=updateUser&user_id=" . $id);
            }
        }
        else if (isset($_POST["first_name"], $_POST["last_name"], $_POST["email"],$_POST["role"], $_POST["created_at"])) {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $email = $_POST["email"];
            $role = $_POST["role"];
            $created_at = $_POST["created_at"];
            $regexEmail = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9._%+-]+\.[A-Za-z]{2,}$/';

            if (preg_match($regexEmail, $_POST["email"]) && !empty(trim($first_name)) && !empty(trim($last_name))
                && !empty(trim($role)) && !empty(trim($created_at))) {
                $user = $this->um->findOne($id);
                $newUser = new User($first_name, $last_name, $email, $user->getPassword(), $role, DateTime::createFromFormat('Y-m-d H:i:s', $created_at), $id);

                if ($newUser !== null) {
                    $this->um->update($newUser);
                    unset($_SESSION["error"]);
                    $this->redirect("index.php?route=showUser&user_id=" . $newUser->getId());
                } else {
                    $_SESSION["error"] = "Oops";
                    $this -> redirect("index.php?route=updateUser&user_id=" . $id);
                }
            }
            else {
                $_SESSION["error"] = "Champs manquants";
                $this -> redirect("index.php?route=updateUser&user_id=" . $id);
            }
        }
        else{
            $_SESSION["error"] = "Champs manquants";
            $this -> redirect("index.php?route=updateUser&user_id=" . $id);
        }
    }

    public function checkCreate(){
        if (isset($_POST["first_name"], $_POST["last_name"], $_POST["email"], $_POST["password"], $_POST["role"])){
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $role = $_POST["role"];
            $regexEmail = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9._%+-]+\.[A-Za-z]{2,}$/';

            if(preg_match($regexEmail, $_POST["email"]) && !empty(trim($first_name))
                && !empty(trim($last_name)) && !empty(trim($role)) && !empty(trim($password)) ){
                $securedPassword = password_hash($password, PASSWORD_DEFAULT);
                $user = new User($first_name, $last_name, $email, $securedPassword, $role);
                $this -> um -> create($user);
                $data= [];
                $this -> redirect("index.php?route=showUser&user_id=".$user -> getId());
            }
            else{
                $_SESSION["error"] = "Champs manquants";
                $this -> renderAdmin("_admin/user/createUser", $_SESSION["error"]);
            }
        }
        else{
            $_SESSION["error"] = "Champs manquants";
            $this -> renderAdmin("_admin/user/createUser", $_SESSION["error"]);
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
        unset($_SESSION["token"]);
        $this -> redirect("index.php");
    }

//CLIENT

    public function homeClient(array $data){
        $this -> renderAdmin("_client/homeClient", $data);
    }

    public function rdvClient(){
        $this -> renderAdmin("_client/rdvClient", []);
    }

}