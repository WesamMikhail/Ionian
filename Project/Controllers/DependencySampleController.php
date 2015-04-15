<?php
namespace Project\Controllers;

use Ionian\Core\Controller;
use Ionian\Database\Database;
use Ionian\Logging\Logger;

use Cake\Utility\Hash;
use Faker\Factory as FF;
use Respect\Validation\Validator as V;
use League\Plates;
use Upload;
use Ubench;


class DependencySampleController extends Controller {
    public function testAction() {
        $bench = new Ubench;
        $bench->start();

        //Logger::Log("Test Log" , "Message!");

        $faker = FF::create();

        $things = [
            ['name' => $faker->name, 'age' => 15],
            ['name' => $faker->name, 'age' => 30],
            ['name' => $faker->name, 'age' => 25]
        ];

        $names = Hash::extract($things, '{n}[age>21].name');

        $this->outputJSON("SAMPLE MSG", $names);

        $bench->end();

        echo "Script took " . $bench->getTime() . " To execute!";
    }

    public function test2Action(){
        $storage = new Upload\Storage\FileSystem(ROOT . '/Project/Views');
        $file = new Upload\File('foo', $storage);

        // Optionally you can rename the file on upload
        $new_filename = uniqid();
        $file->setName($new_filename);

        // Validate file upload
        $file->addValidations(array(
            // Ensure file is of type "image/png"
            new Upload\Validation\Mimetype('image/png'),

            // Ensure file is no larger than 5M (use "B", "K", M", or "G")
            new Upload\Validation\Size('5M')
        ));

        // Access data about the file that has been uploaded
        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'md5'        => $file->getMd5(),
            'dimensions' => $file->getDimensions()
        );

        // Try to upload file
        try {
            $file->upload();
        } catch (\Exception $e) {
            var_dump($file->getErrors());
        }
    }

    public function test3Action() {
        $db = Database::get()->prepare("SELECT asd FROM testtable");
        $db->execute();
        $value = $db->fetchColumn();

        var_dump(V::numeric()->validate($value));
    }

}