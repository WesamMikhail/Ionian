<?php
require_once "Ionian/init.php";

use Ionian\App\Defined;
use Ionian\Database\Database;

$app = new Defined(Defined::APP_MODE_PROD);
$app->setDb(Database::create("mysql", "127.0.0.1", "blogish", "root", "", [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]));

$app->get("/topics", "TopicsController@listAction");
$app->get("/topics/:", "TopicsController@getAction");
$app->post("/topics", "TopicsController@createAction");
$app->delete("/topics/:", "TopicsController@deleteAction");

$app->get("/topics/:/articles", "ArticlesController@listAction");
$app->get("/topics/:/articles/:", "ArticlesController@getAction");
$app->post("/topics/:/articles", "ArticlesController@createAction");
$app->delete("/topics/:/articles/:", "ArticlesController@deleteAction");

$app->run();
