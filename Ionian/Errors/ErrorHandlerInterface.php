<?php
namespace Ionian\Errors;

Interface ErrorHandlerInterface{
    public function badRequest();

    public function unauthorized();

    public function notFound();

    public function internalServerError();

    public function unavailable();

    public function customError($code, $error, $msg);
}