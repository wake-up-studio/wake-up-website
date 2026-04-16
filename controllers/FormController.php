<?php

class FormController extends AbstractController
{

    public function __construct()
    {
        $this -> fm = new FormManager();
    }

    public function list(){
        $data = $this -> fm -> findAll();
        $this -> renderAdmin("listForms", $data);
    }

}