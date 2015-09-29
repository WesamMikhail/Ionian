<?php
require_once "Ionian/init.php";

use Ionian\App\App;
use Ionian\App\Handles;

//Create an Application
$app = new Rapid(App::APP_MODE_PROD);

//initiate DB via configs.ini --> it will look for the [Database] section in the file!
$app->initDatabaseFromSettingsFile("./configs.ini", [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]);

//Run the application
$app->run();


/*
$app = new Handles(App::APP_MODE_PROD);

$app->initDatabaseFromSettingsFile("./configs.ini", [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]);

$app->post('/u/register', "UserController@registerAction");
$app->post('/u/login', "UserController@loginAction");
$app->post('/u/logout', "UserController@logoutAction");
$app->post('/u/refresh', "UserController@refreshTokenAction");

$app->get('/r/list', "RepositoryController@getResourceListAction");
$app->post('/r/add', "RepositoryController@addResourceAction");
$app->post('/r/remove', "RepositoryController@removeResourceAction");
$app->post('/r/edit', "RepositoryController@editResourceAction");
$app->post('/r/upload', "RepositoryController@fileUploadResourceAction");

$app->run();
*/