<?php
namespace Core;


class View{
    private $data;
    private $css = array();
    private $js = array();
    private $title;
    private $description;
    private $ogTags;

    /**
     * Render the View from the given template!
     */
    public function render($view){
        if(!$this->requireView($view))
            echo "VIEW COULD NOT BE FOUND!";
    }

    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * CSS file to be added to <head>
     *
     * @param String $file filename
     */
    public function addCSS($file){
        $this->css[] = $this->getCSSLink($file);
    }

    /**
     * JS file to be added to <head>
     *
     * @param String $file filename
     */
    public function addJS($file){
        $this->js[] = $this->getJSLink($file);
    }

    /**
     * @return array
     */
    public function getCSS() {
        return $this->css;
    }

    /**
     * @return array
     */
    public function getJS() {
        return $this->js;
    }

    /**
     * Returns absolute URL to image location
     *
     * @param String $file
     * @return string absolute path to img file
     */
    public function getImageLink($file){
        return IMG_FOLDER . $file;
    }

    /**
     * return absolute path for CSS file
     *
     * @param String $file
     * @return string
     */
    public function getCSSLink($file){
        return CSS_FOLDER . $file;
    }

    /**
     * Return absolute path for JS file
     *
     * @param String $file
     * @return string
     */
    public function getJSLink($file){
        return JS_FOLDER . $file;
    }

    /**
     * Convert relative link into absolute path
     *
     * @param String $resource the relative resource destination
     * @return string absolute path to resource
     */
    public function getAbsoluteLink($resource){
        return APPLICATION_FOLDER . $resource;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    public function setDescription($desc){
        $this->description = $desc;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setOGTags($tags){
        $this->ogTags = $tags;
    }

    public function getOGTags(){
        return $this->ogTags;
    }

    /**
     * Load the template/view in case it exists
     *
     * @param String $view filename
     * @return bool true if included, false otherwise
     */
    public function requireView($view){
        if(is_readable(ROOT . "/views/templates/" . $view)){
            require_once ROOT . "/views/templates/" . $view;
            return true;
        }
        else
            return false;
    }
}