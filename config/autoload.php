<?php

require "models/Form.php";
require 'models/User.php';
require "models/Project.php";
require "models/Service.php";

require "managers/AbstractManager.php";
require "managers/UserManager.php";
require 'managers/ProjectManager.php';
require 'managers/ServiceManager.php';
require "managers/FormManager.php";

require "controllers/AbstractController.php";
require "controllers/UserController.php";
require "controllers/ProjectController.php";
require "controllers/FormController.php";
require "controllers/ServiceController.php";

require "services/Router.php";