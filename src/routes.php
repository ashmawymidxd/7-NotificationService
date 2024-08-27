<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\NotificationController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as Capsule;

$app->group('/api', function (RouteCollectorProxy $group) {
    $group->group('/notifications', function (RouteCollectorProxy $group) {
        $group->get('', NotificationController::class . ':index');
        $group->get('/{id}', NotificationController::class . ':show');
        $group->post('', NotificationController::class . ':store');
        $group->put('/{id}', NotificationController::class . ':update');
        $group->delete('/{id}', NotificationController::class . ':destroy');
    });

   
});
$app->get('/', function (Request $request, Response $response, $args) {
    try {
        $results = Capsule::select('SELECT DATABASE() AS db');
        $response->getBody()->write(json_encode($results));
    } catch (\Exception $e) {
        $response->getBody()->write($e->getMessage());
    }

    return $response->withHeader('Content-Type', 'application/json');
});