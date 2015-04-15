<?php
namespace Ionian\Errors;

class HTMLErrorHandler extends ErrorHandler{
    public function badRequest(){
        header($this->protocol . " 400 Bad Request.");
        echo $this->template(400, "Bad Request. Parameter missing or malformed URL");
    }

    public function unauthorized(){
        header($this->protocol . " 401 Unauthorized Resource.");
        echo $this->template(401, "Unauthorized Resource. You don't have permission to access this!");
    }

    public function notFound(){
        header($this->protocol . " 404 Page Not Found!");
        echo $this->template(404, "Page Not Found!");
    }

    public function internalServerError() {
        header($this->protocol . " 500 Internal Server Error!");
        echo $this->template(503, "Internal Error. Please contact server administrator!");    }

    public function unavailable(){
        header($this->protocol . " 503 Service Unavailable!");
        echo $this->template(503, "Service Unavailable. Please try again later!");
    }

    public function customError($code, $error, $msg) {
        header($this->protocol . " $code $error");
        echo $this->template($code, $msg);
    }

    protected function template($code, $error){
        $tmp = '<!DOCTYPE HTML>
                <html>
                <head>
                    <meta charset="utf-8">
                    <title>' . $code . ' - ' . $error .  '</title>
                    <style>
                        @import url(http://fonts.googleapis.com/css?family=Bree+Serif|Source+Sans+Pro:300,400);
                        *{maring: 0;padding: 0;}
                        body{font-family: "Source Sans Pro", sans-serif;background: #3f6eb3;color: #1f3759;}
                        #content{margin: 0 auto;width: 960px;}
                        #main-body{text-align: center;}
                        .enormous-font{font-size: 10em;margin-bottom: 0em;font-family: "Bree Serif", serif;}
                        .big-font{font-size: 2em;}
                        hr{width: 25%;height: 1px;background: #1f3759;border: 0px;}
                    </style>
                </head>
                <body>
                    <div id="content">
                        <div id="main-body">
                            <p class="enormous-font">' . $code . ' </p>
                            <p class="big-font"> ' . $error . '</p>
                            <hr>
                        </div>
                    </div>
                </body>
                </html>';

        return $tmp;
    }
}