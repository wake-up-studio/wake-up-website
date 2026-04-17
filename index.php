<?php

error_reporting(E_ALL & ~E_DEPRECATED);

require "config/autoload.php";

$router = new Router();
$router -> handleRequest($_GET);