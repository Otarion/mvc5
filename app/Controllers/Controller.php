<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

abstract class Controller {
    protected Environment $twig;
    protected Response $response;

    public function __construct(Response $response, Environment $twig){
        $this -> response = $response;
        $this->twig = $twig;
    }

    protected function view (string $template, array $data = []) : Response {
        return new Response ($this->twig->render($template, $data));
    }

}