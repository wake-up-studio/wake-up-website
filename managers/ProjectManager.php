<?php

class ProjectManager extends AbstractManager{
    public function __construct(){
        parent::__construct();
    }

    public function findAll() : array {
        $query = $this -> db -> prepare("
                SELECT *
                FROM projects
            ");
        $query -> execute();
        $results = $query -> fetchAll(PDO::FETCH_ASSOC);
        $projects = [];
        foreach($results as $result){
            $projects[] = new Project ($result["title"], $result["content"], $result["user_id"], DateTime::createFromFormat("Y-m-d H:i:s", $result["created_at"] ), $result["id"]);
        }
        return $projects;
    }

    public function findByUserId(int $id) : ?array{
        $query = $this -> db -> prepare("
            SELECT *
            FROM projects
            WHERE user_id = :user_id
        ");
        $parameters = ["user_id" => $id];
        $query -> execute($parameters);
        $results = $query -> fetchAll(PDO::FETCH_ASSOC);
        $projects = [];
        foreach($results as $result){
            $projects[] = new Project ($result["title"], $result["content"], $result["user_id"], DateTime::createFromFormat("Y-m-d H:i:s", $result["created_at"] ), $result["id"]);
        }
        if(count($projects) != 0){
            return $projects;
        }
        return null;
    }

    public function findOne(int $id) : ?Project{
        $query = $this -> db -> prepare("
            SELECT *
            FROM projects
            WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
        $result = $query -> fetch(PDO::FETCH_ASSOC);
        if($result){
            $project = new Project($result["title"], $result["content"], $result["user_id"], DateTime::createFromFormat("Y-m-d H:i:s", $result["created_at"] ), $result["id"]);
            return $project;
        }
        return null;
    }

    public function delete(int $id){
        $query = $this -> db -> prepare("
        DELETE FROM projects
        WHERE id = :id
        ");
        $parameters = ["id" => $id];
        $query -> execute($parameters);
    }

    public function create(Project $project){
        $query = $this -> db -> prepare("
        INSERT INTO projects(title, content, user_id, created_at)
        VALUES(:title, :content, :user_id, NOW())
        ");
        if($project -> getUserId() !== null){
            $parameters = ["title" => $project->getTitle(),
                "content" => $project->getContent(),
                "user_id" => intval($project->getUserId())
            ];
        }
        else{
            $parameters = ["title" => $project->getTitle(),
                "content" => $project->getContent(),
                "user_id" => $project->getUserId()
            ];
        }
        $query -> execute($parameters);

        $id = $this -> db -> lastInsertId();
        $project->setId($id);
    }

    public function update(Project $project){
        $query = $this -> db -> prepare("
        UPDATE projects
        SET title = :title,
        content = :content,
        created_at = :created_at,
        user_id = :user_id
        WHERE id = :id");
        if($project -> getUserId() !== null){
            $parameters = ["title" => $project->getTitle(),
                "content" => $project->getContent(),
                "created_at" => $project->getCreatedAt() -> format("Y-m-d H:i:s"),
                "user_id" => intval($project->getUserId()),
                "id" => $project->getId()
            ];
        }
        else{
            $parameters = ["title" => $project->getTitle(),
                "content" => $project->getContent(),
                "created_at" => $project->getCreatedAt() -> format("Y-m-d H:i:s"),
                "user_id" => $project->getUserId(),
                "id" => $project->getId()
            ];
        }
        $query -> execute($parameters);
    }
}

?>
