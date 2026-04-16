<?php

abstract class AbstractController
{
    protected function renderAdmin(string $template, array $data) : void
    {
        require "templates/admin/layout.phtml";
        // var_dump($data);
    }

    protected function renderFront(string $template, array $data) : void
    {
        require "templates/front/layout.phtml";
        // var_dump($data);
    }

    protected function redirect(string $route) : void
    {
        header("Location: $route");
    }
}

?>
