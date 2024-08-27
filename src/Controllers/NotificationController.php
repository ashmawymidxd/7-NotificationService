<?php

namespace App\Controllers;

use App\Models\Notification;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

class NotificationController
{
    public function index(Request $request, Response $response)
    {
        $notifications = Notification::all();
        $response->getBody()->write($notifications->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(Request $request, Response $response, $args)
    {
        $notification = Notification::find($args['id']);
        if ($notification) {
            $response->getBody()->write($notification->toJson());
            return $response->withHeader('Content-Type', 'application/json');
        }
        return $response->withStatus(404);
    }

    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        // Define validation rules
        $validator = v::key('user_id', v::stringType()->notEmpty())
            ->key('message', v::stringType()->notEmpty());

        // Validate the data
        try {
            $validator->assert($data);

            // Data is valid, create the notification
            $notification = Notification::create($data);
            $response->getBody()->write($notification->toJson());
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

        } catch (\Respect\Validation\Exceptions\ValidationException $e) {
            // Data is invalid, return validation errors
            $errors = $e->getMessages();
            $response->getBody()->write(json_encode(['errors' => $errors]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }

    public function update(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $notification = Notification::find($args['id']);
        if ($notification) {
            $notification->update($data);
            $response->getBody()->write($notification->toJson());
            return $response->withHeader('Content-Type', 'application/json');
        }
        return $response->withStatus(404);
    }

    public function destroy(Request $request, Response $response, $args)
    {
        $notification = Notification::find($args['id']);
        if ($notification) {
            $notification->delete();
            return $response->withStatus(204);
        }
        return $response->withStatus(404);
    }

}