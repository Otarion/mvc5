<?php

// Front controller (toutes les requêtes passent par ici)

// Autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// On récupère une instance de la classe App
$app = MVC\App::getInstance();
// Servira à ajouter mes services au conteneur
$app->boot();

// On récupère l'instance du service router
$router = $app->make('router');
// On appelle sa méthode dispatch() pour trouver la route correspondant à la requête de notre visiteur
$response = $router->dispatch();
//Envoyer une réponse au visiteur
$response-> send();

$loader = new \Twig\Loader\FilesystemLoader;
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);