<?php

error_reporting(E_ALL & ~E_DEPRECATED);

require "config/autoload.php";

require __DIR__ . '/vendor/autoload.php';
// Chargement des variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router();
$router -> handleRequest($_GET);