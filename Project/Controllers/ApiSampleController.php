<?php
namespace Project\Controllers;

use Ionian\Core\Controller;

class ApiSampleController extends Controller {
    public function indexAction() {
        $this->outputJSON(200, "SAMPLE INDEX MSG");
    }

    public function DBAction() {
        /*
            Get something from DB using:

            $db = Database::get()->prepare("SELECT asd FROM testtable");
            $db->execute();
            $value = $db->fetchColumn();
         */

        $value = 123;

        $this->outputJSON("$value was found!");
    }

    public function parameterAction($param) {
        $this->outputJSON("PARAMETER WAS SUPPLIED!", $param);
    }

    public function optionalAction($param, $optional = null) {
        $this->outputJSON("Paramters supplied", [$param, $optional]);
    }

    public function errorAction($param) {
        if ($param == 100) {
            $this->outputJSON("You used parameter value 100 which is authorized!");
        }
        else {
            $this->errorHandler->unauthorized();
        }
    }
}