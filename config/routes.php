<?php

// config/routes.php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use App\Controller\LuckyController;

$routes = new RouteCollection();
$routes->add('lucky_random', new Route('/lucky', array(
    '_controller' => [LuckyController::class, 'number']
)));

return $routes;