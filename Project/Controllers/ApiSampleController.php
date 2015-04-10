<?php
namespace Project\Controllers;

use Ionian\Core\APIDump;
use Ionian\Core\Controller;

class ApiSampleController extends Controller {
    public function indexAction(){
        APIDump::output(200, "SAMPLE INDEX API MSG");
    }

    public function DBAction(){
        /*
            Get something from DB using:

            $db = Database::get()->prepare("SELECT asd FROM testtable");
            $db->execute();
            $value = $db->fetchColumn();
         */

        $value = 123;

        APIDump::output(200, "$value was found!");
    }

    public function parameterAction($param){
        APIDump::output(200, "PARAMETER WAS SUPPLIED!", $param);
    }

    public function optionalAction($param, $optional = null){
        APIDump::output(200, "Paramters supplied", [$param, $optional]);
    }

    public function errorAction($param){
        if($param == 100){
            APIDump::output(200, "You used parameter value 200");
        }
        else{
            $this->errorHandler->unauthorized();
        }
    }
}