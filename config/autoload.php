<?php

require "models/Form.php";
require 'models/User.php';
require "models/Project.php";
require "models/Service.php";
require "models/Question.php";
require "models/Media.php";

require "managers/AbstractManager.php";
require "managers/UserManager.php";
require 'managers/ProjectManager.php';
require 'managers/ServiceManager.php';
require "managers/FormManager.php";
require "managers/QuestionManager.php";
require "managers/MediaManager.php";

require "controllers/AbstractController.php";
require "controllers/UserController.php";
require "controllers/ProjectController.php";
require "controllers/FormController.php";
require "controllers/ServiceController.php";
require "controllers/QuestionController.php";
require "controllers/MediaController.php";

require "services/Router.php";