<?php

class ServiceController extends AbstractController
{

    public function __construct()
    {
        $this -> sm = new ServiceManager();
    }

    public function list(){
        $data = $this -> sm -> findAll();
        $this -> renderAdmin("listServices", $data);
    }

}