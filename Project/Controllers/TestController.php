<?php
namespace Project\Controllers;

use Ionian\Core\Controller;
use Ionian\Core\View;
use Ionian\Database\Database;
use Ionian\Logging\Logger;

use CakePHP\Utility\Hash;
use Ubench\Ubench;
use Faker;

class TestController extends Controller {
    public function testAction($value) {
        $bench = new Ubench;
        $bench->start();

        //Logger::Log("Test Log" , "Message!");

        $faker = Faker\Factory::create();

        $things = [
            ['name' => $faker->name, 'age' => 15],
            ['name' => $faker->name, 'age' => 30],
            ['name' => $faker->name, 'age' => 25]
        ];

        $names = Hash::extract($things, '{n}[age>21].name');

        $view = new View("IndexView.php", $names);
        $view->render();

        $bench->end();

        echo "Script took " . $bench->getTime() . " To execute!";
    }

    public function test3Action() {
        $db = Database::get()->prepare("SELECT * FROM testtable");
        $db->execute();
        var_dump($db->fetchAll());
    }

}