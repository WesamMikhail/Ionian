<?php
require_once "Ionian/init.php";

use Ionian\App;

//Create an Application
$app = new App\Rapid(App\App::APP_MODE_DEV);

//You can create multiple DB instances. This however initializes the DEFAULT instance.
$app->initDatabase("mysql", "127.0.0.1", "test", "root", "", [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]);

//By default we include the framework built-in error handler. You can include your own by using this command!
//$app->setErrorHandler(new \Project\Handlers\CustomErrorHandler());

//Run the application
$app->run();

/*
$app = new App\Defined(App\App::APP_MODE_DEV);
$app->initDatabase("mysql", "127.0.0.1", "test", "root", "", [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]);
$app->get('/test1', "DependencySampleController@test3Action");
$app->run();
*/