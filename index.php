<?php
require_once "Ionian/init.php";

use Ionian\App\App;
use Ionian\App\Rapid;

//Create an Application
$app = new Rapid(App::APP_MODE_PROD);

//initiate DB via configs.ini --> it will look for the [Database] section in the file!
$app->initDatabaseFromSettingsFile("./configs.ini", [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]);

//Run the application
$app->run();