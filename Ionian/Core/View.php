<?php
namespace Ionian\Core;

class View{
    protected $view;
    protected $data;
    protected $css = array();
    protected $js = array();
    protected $title;
    protected $description;
    protected $ogTags = array();

    function __construct($view, $data = null){
        $this->view = $view;
        $this->setData($data);
    }

    /**
     * getView requires the view file. If the file is not found, E_NOTICE will be issued!
     */
    protected function getView($view){
        $view = ROOT. "/Project/Views/" . $view;
        if(!is_readable($view)){
            trigger_error("VIEW COULD NOT BE FOUND!");
        }
        else{
            require_once $view;
        }
    }

    /**
     * Render will output the view onto the screen!
     * Header is always 200 OK! If anything else needs to be issued, use the ErrorHandler!
     */
    public function render(){
        $this->getView($this->view);
    }

    /**
     * CSS file to be added to <head>
     *
     * @param String $file filename
     */
    public function addCSS($file){
        $this->css[] = $file;
    }

    /**
     * JS file to be added to <head>
     *
     * @param String $file filename
     */
    public function addJS($file){
        $this->js[] = $file;
    }

    /**
     * Adds Open Graph tag to be displayed in the view
     *
     * @param $key tag key Ex. og:title
     * @param $value tag value
     */
    public function addOGTag($key, $value){
        $this->ogTags[$key] = $value;
    }

    /**
     * @param array $css
     */
    public function setCss(array $css) {
        $this->css = $css;
    }

    /**
     * @return array
     */
    public function getCss() {
        return $this->css;
    }

    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param array $js
     */
    public function setJs(array $js) {
        $this->js = $js;
    }

    /**
     * @return array
     */
    public function getJs() {
        return $this->js;
    }

    /**
     * @param mixed $ogTags
     */
    public function setOgTags(array $ogTags) {
        $this->ogTags = $ogTags;
    }

    /**
     * @return mixed
     */
    public function getOgTags() {
        return $this->ogTags;
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
}