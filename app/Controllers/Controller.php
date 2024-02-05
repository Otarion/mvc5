<?php

namespace App\Controllers;

use MVC\Response;

class Controller {
    protected Response $response;

    public function __construct(Response $response){
        $this -> response = $response;
    }
}
