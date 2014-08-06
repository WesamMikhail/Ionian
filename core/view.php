<?php
namespace Core;


class View{
    private $data;
    private $css = array();
    private $js = array();
    private $title = "Untitled Page!";


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
        $this->css[] = "/views/css/" . $file;
    }

    /**
     * JS file to be added to <head>
     *
     * @param String $file filename
     */
    public function addJS($file){
        $this->js[] = "/views/js/" . $file;
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