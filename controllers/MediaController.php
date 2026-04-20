<?php

class MediaController extends AbstractController
{

    public function __construct()
    {
        $this -> mm = new MediaManager();
    }

    public function list(){
        $data = $this -> mm -> findAll();
        $this -> renderAdmin("media/listMedias", $data);
    }

    public function show(int $id){
        $data = ["media" => $this -> mm -> findOne($id)];
        $this -> renderAdmin("media/showMedia", $data);
    }

    public function update(int $id){
        $media = $this -> mm -> findone($id);
        $this -> renderAdmin("media/updateMedia", ["media" => $media]);
    }

    public function create(){
        $this -> renderAdmin("media/createMedia", []);
    }

    //n'affiche rien

    public function delete(int $id){
        $this -> mm -> delete($id);
        $this -> redirect("index.php");
    }

    public function checkUpdate(int $id){
        if (isset($_POST["alt"],$_POST["url"])){
            $alt = $_POST["alt"];
            $url = $_POST["url"];

            if(!empty(trim($alt)) && !empty(trim($url))){
                $media = new Media($alt, $url, $id);

                if($media !== null){
                    $this -> mm -> update($media);
                    $this -> redirect("index.php?route=showMedia&media_id=".$media -> getId());
                }
                else{
                    $data = ["error" => "Oops"];
                    $this -> renderAdmin("media/updateMedia", $data);
                }
            }
            else{
                $data = ["error" => "Champs manquants"];
                $this -> renderAdmin("media/updateMedia", []);
            }
        }
        else{
            $data = ["error" => "Champs manquants"];
            $this -> renderAdmin("media/updateMedia", []);
        }
    }

    public function checkCreate(){
        if (isset($_POST["alt"],$_POST["url"])){
            $alt = $_POST["alt"];
            $url = $_POST["url"];

            if(!empty(trim($alt)) && !empty(trim($url))){
                $media = new Media($alt, $url);
                $this -> mm -> create($media);
                $this -> redirect("index.php?route=showMedia&media_id=".$media -> getId());
            }
            else{
                $data = ["error" => "Champs manquants"];
                $this -> renderAdmin("media/createMedia", []);
            }
        }
        else{
            $data = ["error" => "Champs manquants"];
            $this -> renderAdmin("media/createMedia", []);
        }
    }

}