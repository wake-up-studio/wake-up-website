<?php

require "config/autoload.php";

error_reporting(E_ALL & ~E_DEPRECATED);

$router = new Router();
$router -> handleRequest($_GET);
