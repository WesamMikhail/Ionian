<?php
namespace Tests\Project\Controllers;

use PHPUnit_Framework_TestCase;
use GuzzleHttp\Client;
use PDO;

class TopicsControllerTest extends PHPUnit_Framework_TestCase {
    protected $client;

    public function setUp(){
        $this->client = new Client([
            'base_url' => 'http://localhost',
            'defaults' => [
                'exceptions' => false,
                'headers' => [
                    'Content-Type'     => 'Content-Type: application/json;charset=UTF-8'
                ]
            ]
        ]);
    }

    /**
     * Static method to clean up the DB after the test is done running
     */
    public static function tearDownAfterClass(){
        $db = new PDO('mysql:host=localhost;dbname=blogish', "root", "");

        //cascade delete
        $stm = $db->prepare("DELETE FROM topics");
        $stm->execute();
    }

    public function testCreateTopicWithEmptyTitle(){
        $response = $this->client->post('/Ionian/topics', [
            "json" => [
                'title'            => ''
            ]
        ]);
        $this->assertEquals(400, $response->getStatusCode());
    }


    public function testSuccessfulInsertion(){
        $response = $this->client->post('/Ionian/topics', [
            "json" => [
                'title'            => 'First'
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @depends testSuccessfulInsertion
     */
    public function testDuplicateTopicTitle(){
        $response = $this->client->post('/Ionian/topics', [
            "json" => [
                'title'            => 'First'
            ]
        ]);
        $this->assertEquals(409, $response->getStatusCode());
    }


    public function testGetTopicThatDoesNotExist(){
        $response = $this->client->get('/Ionian/topics/9999999');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testSuccessfulGetTopic(){
        $response = $this->client->post('/Ionian/topics', [
            "json" => [
                'title'            => '!2fasnia8SG2sfa!#'
            ]
        ]);
        $response = json_decode($response->getBody()->read(10000), true);
        $id = $response["data"]["topic_id"];

        $response = $this->client->get('/Ionian/topics/' . $id);
        $this->assertEquals(200, $response->getStatusCode());
    }
}