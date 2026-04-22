<?php

class UserManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }

    public function findAll() : array {
        $query = $this -> db -> prepare("
                SELECT *
                FROM users
            ");
        $query -> execute();
        $results = $query -> fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach($results as $result){
            $users[] = new User($result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["role"],DateTime::createFromFormat('Y-m-d H:i:s', $result["created_at"]), $result["id"]);
        }
        return $users;
    }

    public function findOne(int $id) : ?User{
        $query = $this -> db -> prepare("
            SELECT *
            FROM users
            WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
        $result = $query -> fetch(PDO::FETCH_ASSOC);
        if($result){
            $user = new User($result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["role"],DateTime::createFromFormat('Y-m-d H:i:s', $result["created_at"]), $result["id"]);
            return $user;
        }
        return null;
    }

    public function findByEmail(string $email) : ?User{
        $query = $this -> db -> prepare("
            SELECT *
            FROM users
            WHERE email = :email
        ");
        $parameters = ["email" => $email];
        $query -> execute($parameters);
        $result = $query -> fetch(PDO::FETCH_ASSOC);
        if($result){
            $user = new User($result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["role"],DateTime::createFromFormat('Y-m-d H:i:s', $result["created_at"]), $result["id"]);
            return $user;
        }
        return null;
    }

    public function delete(int $id){
        $query = $this -> db -> prepare("
        DELETE FROM users
        WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
    }

    public function create(User $user){
        $query = $this -> db -> prepare("
        INSERT INTO users
        (first_name, last_name, email, password, role, created_at)
        VALUES (:first_name, :last_name, :email, :password, :role, NOW())
        ");
        $parameters = ["first_name" => $user->getFirstName(),
            "last_name" => $user->getLastName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "role" => $user->getRole()
            ];
        $query -> execute($parameters);
        $id = $this -> db -> lastInsertId();
        $user->setId($id);
    }

    public function update(User $user){
        $query = $this -> db -> prepare("
        UPDATE users
        SET first_name = :first_name,
            last_name = :last_name,
            email = :email,
            password = :password,
            role = :role,
            created_at = :created_at
            WHERE id = :id
            ");
        $parameters = ["first_name" => $user->getFirstName(),
            "last_name" => $user->getLastName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "role" => $user->getRole(),
            "created_at" => $user->getCreatedAt() -> format("Y-m-d H:i:s"),
            "id" => $user->getId()];
        $query -> execute($parameters);
    }

}

?>
