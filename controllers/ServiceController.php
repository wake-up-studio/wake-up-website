<?php

class ServiceController extends AbstractController
{

    public function __construct()
    {
        $this -> sm = new ServiceManager();
    }

    public function list(){
        $data = $this -> sm -> findAll();
        $this -> renderAdmin("backOffice/service/listServices", $data);
    }

    public function show(int $id){
        $service = $this -> sm -> findOne($id);
        $this -> renderAdmin("backOffice/service/showService", ["service" => $service]);
    }

    public function update(int $id){
        $service = $this -> sm -> findOne($id);
        $this -> renderAdmin("backOffice/service/updateService", ["service" => $service]);
    }

    public function create(){
        $this -> renderAdmin("backOffice/service/createService", []);
    }

    //n'affiche rien

    public function delete(int $id){
        $this -> sm -> delete($id);
        $this -> redirect("?route=listServices");
    }

    public function checkUpdate(int $id){
        if (isset($_POST["title"], $_POST["content"])){
            $title = $_POST["title"];
            $content = $_POST["content"];
            $created_at = $_POST["created_at"];

            if(!empty(trim($title)) && !empty(trim($content))){
                $service = new Service($title, $content, DateTime::createFromFormat("Y-m-d H:i:s", $created_at), $id);

                if($service !== null){
                    $this -> sm -> update($service);
                    $this -> redirect("index.php?route=showService&service_id=".$service -> getId());
                }
                else{
                    $data = ["error" => "Oops"];
                    $this -> renderAdmin("backOffice/service/updateService", $data);
                }
            }
            else{
                $data = ["error" => "Champs manquants"];
                $this -> renderAdmin("backOffice/service/updateService", []);
            }
        }
        else{
            $data = ["error" => "Champs manquants"];
            $this -> renderAdmin("backOffice/service/updateService", []);
        }
    }

    public function checkCreate(){
        if (isset($_POST["title"], $_POST["content"])){
            $title = $_POST["title"];
            $content = $_POST["content"];

            if(!empty(trim($title)) && !empty(trim($content))){
                $service = new Service($title, $content);
                $this -> sm -> create($service);
                $this -> redirect("index.php?route=showService&service_id=".$service -> getId());
            }
            else{
                $data = ["error" => "Champs manquants"];
                $this -> renderAdmin("backOffice/service/createService", []);
            }
        }
        else{
            $data = ["error" => "Champs manquants"];
            $this -> renderAdmin("backOffice/service/createService",[]);
        }
    }

}