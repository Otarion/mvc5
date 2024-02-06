<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends Controller
{

    public function index()
    {
        return new Response ('Hello world');
    }

    public function hello(string $name): Response
    {
        return $this->view('hello.html', ['name' => $name]);
    }
}
