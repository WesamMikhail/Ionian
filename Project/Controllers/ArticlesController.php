<?php
namespace Project\Controllers;

use Ionian\Core\Controller;
use Ionian\Request\Request;
use Ionian\Errors\Exceptions\HTTPException_400;
use Ionian\Errors\Exceptions\HTTPException_404;
use Ionian\Errors\Exceptions\HTTPException_500;


class ArticlesController extends Controller{

    /**
     * POST /topics/:/articles
     * @param $topicID
     * @throws HTTPException_400
     * @throws HTTPException_500
     */
    public function createAction($topicID){
        $title = Request::body("title");
        $author = Request::body("author");
        $content = Request::body("content");

        //Sanity check the title. We could do more such as sanitation, SS-XSS prevention and other stuff here
        if(empty($title) || empty($author) || empty($content)){
            throw new HTTPException_400("All of the following fields must be filled: 'title', 'author' and 'content'.");
        }

        $stm = $this->db->prepare("INSERT INTO articles (parent_id, title, author, content) VALUES (:pid, :t, :a, :c)");
        $res = $stm->execute([
            ":pid"  => $topicID,
            ":t"    => $title,
            ":a"    => $author,
            ":c"    => $content
        ]);

        if(!$res){
            throw new HTTPException_400("Unable to insert article. Please make sure that you have the right topicID specified in the URL and proper formatted values.");
        }

        self::outputJSON("Successful insert.", ["article_id" => $this->db->lastInsertId()]);
    }

    /**
     * Delete /topics/:/articles/:
     * @param $topicID
     * @param $articleID
     * @throws HTTPException_500
     */
    public function deleteAction($topicID, $articleID){
        //We could use the $topicID to make some restrictions her eif we wanted to!

        $stm = $this->db->prepare("DELETE FROM articles WHERE id = :id");
        $res = $stm->execute([":id" => $articleID]);

        if(!$res){
            throw new HTTPException_500;
        }

        self::outputJSON("Successful Delete.");
    }

    /**
     * GET /topics/:/articles
     * @param $topicID
     */
    public function listAction($topicID){
        //Listing the topics actually requires nothing more than this.

        $stm = $this->db->prepare("SELECT * FROM articles WHERE parent_id = :topicID");
        $stm->execute([":topicID" => $topicID]);
        self::outputJSON("Successful Listing.", $stm->fetchAll());
    }

    /**
     * GET /topics/:/articles/:
     * @param $topicID
     * @param $articleID
     * @throws HTTPException_404
     */
    public function getAction($topicID, $articleID){
        //If the topic is not found then the article is not going to be found either, so we could sanity check for that as well!

        $stm = $this->db->prepare("SELECT * FROM articles WHERE id = :id");
        $stm->execute([":id" => $articleID]);

        if($stm->rowCount() == 0){
            throw new HTTPException_404("Article by ID $articleID not found");
        }

        self::outputJSON("Successful Select.", $stm->fetch());
    }
}