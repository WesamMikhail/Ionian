<?php
namespace Project\Controllers;

use Ionian\Core\Controller;
use Ionian\Request\Request;
use Ionian\Errors\Exceptions\HTTPException_400;
use Ionian\Errors\Exceptions\HTTPException_404;
use Ionian\Errors\Exceptions\HTTPException_409;
use Ionian\Errors\Exceptions\HTTPException_500;

Class TopicsController extends  Controller{

    /**
     * POST /topics
     * @throws HTTPException_400
     * @throws HTTPException_500
     */
    public function createAction(){
        //Get the article title from the request body
        $title = Request::body("title");

        //Sanity check the title. We could do more such as sanitation, SS-XSS prevention and other stuff here
        if(empty($title)){
            throw new HTTPException_400("'title' field must be provided in the request body.");
        }

        $stm = $this->db->prepare("INSERT INTO topics (title) VALUES (:title)");
        $res = $stm->execute([":title" => $title]);

        //If insertion fails, show a friendly message
        if(!$res){
            throw new HTTPException_409("Topic already exists.");
        }

        self::outputJSON("Successful Insertion.", ["topic_id" => $this->db->lastInsertId()]);
    }

    /**
     * DELETE /topics/:
     * @param $topicID
     * @throws HTTPException_500
     */
    public function deleteAction($topicID){
        $stm = $this->db->prepare("DELETE FROM topics WHERE id = :id");
        $res = $stm->execute([":id" => $topicID]);

        if(!$res){
            throw new HTTPException_500;
        }

        self::outputJSON("Successful Delete.");
    }

    /**
     * GET /topics
     */
    public function listAction(){
        $stm = $this->db->prepare("SELECT * FROM topics");
        $stm->execute();
        self::outputJSON("Successful Listing.", $stm->fetchAll());
    }

    /**
     * GET /topics/:
     * @param $topicID
     * @throws HTTPException_404
     */
    public function getAction($topicID){
        $stm = $this->db->prepare("SELECT * FROM topics WHERE id = :id");
        $stm->execute([":id" => $topicID]);

        if($stm->rowCount() == 0){
            throw new HTTPException_404("Topic by ID $topicID not found");
        }

        self::outputJSON("Successful Select.", $stm->fetch());
    }
}