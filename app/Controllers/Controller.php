<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class Controller {
    protected Response $response;

    public function __construct(Response $response){
        $this -> response = $response;
    }
}
