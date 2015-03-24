<?php
namespace Project\Controllers;

use Ionian\Core\Controller;
use Ionian\Core\View;
use Ionian\Database\Database;
use Ionian\Logging\Logger;

use CakePHP\Utility\Hash;
use Faker;
use Imagine;

class TestController extends Controller{
    public function testAction($value){
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
    }

    public function test2Action(){
        $imagine = new Imagine\Gd\Imagine();
        $size    = new Imagine\Image\Box(40, 40);
        $mode    = Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        $imagine->open(ROOT . "/Project/Views/Images/logo.png")
            ->thumbnail($size, $mode)
            ->save(ROOT . "/Project/Views/Images/logoThumb.png");
    }
}