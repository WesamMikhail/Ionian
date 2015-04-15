<?php
namespace Project\Controllers;

use Ionian\Core\APIDump;
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

        $this->outputJSON(200, "$value was found!");
    }

    public function parameterAction($param) {
        $this->outputJSON(200, "PARAMETER WAS SUPPLIED!", $param);
    }

    public function optionalAction($param, $optional = null) {
        $this->outputJSON(200, "Paramters supplied", [$param, $optional]);
    }

    public function errorAction($param) {
        if ($param == 100) {
            $this->outputJSON(200, "You used parameter value 200");
        }
        else {
            $this->errorHandler->unauthorized();
        }
    }
}