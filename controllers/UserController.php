<?php

class UserController extends AbstractController
{

    public function __construct()
    {
        $this -> um = new UserManager();
    }

    public function list(){
        $data = $this -> um -> findAll();
        $this -> renderAdmin("user/listUsers", $data);
    }

    public function show(int $id){
        $data = [$this -> um -> findOne($id)];
        $this -> renderAdmin("user/showUser", $data);
    }

    public function update(int $id){
        $user = [$this -> um -> findone($id)];
        $this -> renderAdmin("user/updateUser", $user);
    }

    public function create(){
        $this -> renderAdmin("user/createUser", []);
    }

    //n'affiche rien

    public function delete(int $id){
        $this -> um -> delete($id);
        $this -> redirect("index.php");
    }

    public function checkUpdate(int $id){
        if (isset($_POST["email"],$_POST["role"])){
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);
            $role = htmlspecialchars($_POST["role"]);
            $created_at = htmlspecialchars($_POST["created_at"]);
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
                    $this -> renderAdmin("user/updateUser", $data);
                }
            }
            else{
                $data = ["error" => "Champs manquants"];
                $this -> renderAdmin("user/updateUser", []);
            }
        }
        else{
            $data = ["error" => "Champs manquants"];
            $this -> renderAdmin("user/updateUser", []);
        }
    }

    public function checkCreate(){
        if (isset($_POST["email"], $_POST["password"], $_POST["role"])){
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);
            $role = htmlspecialchars($_POST["role"]);
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
                $this -> renderAdmin("user/createUser", []);
            }
        }
        else{
            $data = ["error" => "Champs manquants"];
            $this -> renderAdmin("user/createUser", []);
        }
    }

}