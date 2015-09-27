<?php
namespace Project\Controllers;

use Ionian\Core\Controller;
use Ionian\Database\Database;
use Ionian\Errors\Exceptions\HTTPException_400;
use Ionian\Errors\Exceptions\HTTPException_500;

class FoodController extends Controller {
    protected $food = ["any", "thing", "you", "like"];

    public function getListAction(){
        self::outputJSON("Successful Request!", $this->food);
    }

    public function addToDBAction(){
        if(!(isset($_POST["food"])))
            throw new HTTPException_400("Missing parameter food.");

        $stm = Database::get()->prepare("INSERT INTO food_tbl (name) VALUES (:name)");
        $res = $stm->execute([
            ":name" => $_POST["food"]
        ]);

        if(!$res)
            throw new HTTPException_500("Unable to run the SQL command.");

        self::outputJSON("Successful Addition");
    }
}