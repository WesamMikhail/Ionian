<?php

use GuzzleHttp\Client;

class RapidAppURITest extends PHPUnit_Framework_TestCase{
    protected $client;

    protected function setUp(){
        $this->client = new Client([ 'base_url' => 'http://localhost', 'defaults' => ['exceptions' => false]]);
    }

    public function testIncorrectURICombinations(){
        //Root should fail because Rapid uses C/A methodology
        $response = $this->client->get('/Ionian');
        $this->assertEquals(400, $response->getStatusCode());

        //Valid Controller only should fail because no action is supplied 400
        $response = $this->client->get('/Ionian/ApiSample');
        $this->assertEquals(400, $response->getStatusCode());

        //In-Valid Controller only should fail because no action is supplied 400
        $response = $this->client->get('/Ionian/SomeController');
        $this->assertEquals(400, $response->getStatusCode());

        //Invalid controller and action should give us 404
        $response = $this->client->get('/Ionian/SomeController/SomeAction');
        $this->assertEquals(404, $response->getStatusCode());

        //Valid controller and invalid action should give us 404 as well
        $response = $this->client->get('/Ionian/ApiSample/SomeAction');
        $this->assertEquals(404, $response->getStatusCode());
    }


    public function testURIParameters(){
        //Valid controller and valid action and unexpected param should give us 400
        $response = $this->client->get('/Ionian/ApiSample/index/asd');
        $this->assertEquals(400, $response->getStatusCode());

        //Valid controller and valid action and invalid params count should give us 400
        $response = $this->client->get('/Ionian/ApiSample/parameter/');
        $this->assertEquals(400, $response->getStatusCode());

        //Valid controller and valid action and invalid params count should give us 400
        $response = $this->client->get('/Ionian/ApiSample/parameter/p1/p2');
        $this->assertEquals(400, $response->getStatusCode());

        //Valid controller and valid action and invalid params count should give us 400
        $response = $this->client->get('/Ionian/ApiSample/optional/p1/p2/p3');
        $this->assertEquals(400, $response->getStatusCode());

    }

    public function testSuccessCases(){
        //Test trailing slash
        $response = $this->client->get('/Ionian/ApiSample/index/');
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->client->get('/Ionian/ApiSample/index');
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->client->get('/Ionian/ApiSample/parameter/123');
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->client->get('/Ionian/ApiSample/optional/11');
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->client->get('/Ionian/ApiSample/optional/11/22');
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->client->get('/Ionian/ApiSample/error/100');
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->client->get('/Ionian/ApiSample/error/200');
        $this->assertEquals(401, $response->getStatusCode());

        //Test trailing slash with params
        $response = $this->client->get('/Ionian/ApiSample/optional/11/');
        $this->assertEquals(200, $response->getStatusCode());

        //Test trailing slash without params
        $response = $this->client->get('/Ionian/ApiSample/index/////');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testURISymbols(){
        //Any space in URL should result in 403 by the server before PHP is even run!
        $response = $this->client->get('/Ionian/ /asd/');
        $this->assertEquals(403, $response->getStatusCode());

        //Trailing slashes are removed so without C/A it wont work!
        $response = $this->client->get('/Ionian///');
        $this->assertEquals(400, $response->getStatusCode());

        //Trailing slashes are removed so without C/A it wont work!
        $response = $this->client->get('/Ionian/ApiSample//');
        $this->assertEquals(400, $response->getStatusCode());

        //Muted Controller should cause 400 error
        $response = $this->client->get('/Ionian//test/asd');
        $this->assertEquals(400, $response->getStatusCode());

        //Muted Action should cause a 400 error
        $response = $this->client->get('/Ionian/ApiSample//asd');
        $this->assertEquals(400, $response->getStatusCode());

        //Muted Controller and Action should cause a 400 error
        $response = $this->client->get('/Ionian///asd');
        $this->assertEquals(400, $response->getStatusCode());

        //Muted required params
        $response = $this->client->get('/Ionian/ApiSample/optional//asd');
        $this->assertEquals(400, $response->getStatusCode());
    }
}
