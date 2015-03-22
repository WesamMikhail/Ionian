<?php
namespace Ionian\Errors;

Interface ErrorHandler_inter{
    public function badRequest();

    public function notFound();

    public function unauthorized();

    public function unavailable();
}