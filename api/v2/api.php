<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'controllers/ActorApiController.php';

$controller = new ActorApiController();
$method = $_SERVER['REQUEST_METHOD'];
$uri = explode("/", trim($_SERVER['REQUEST_URI'], "/"));

// Ejemplo: /api/actors/5
if ($uri[4] === "api" && $uri[5] === "actors") {
    $id = isset($uri[6]) ? intval($uri[6]) : null;

    switch ($method) {
        case "GET":
            $id ? $controller->show($id) : $controller->index();
            break;
        case "POST":
            $controller->store();
            break;
        case "PUT":
            if ($id) $controller->update($id);
            break;
        case "DELETE":
            if ($id) $controller->delete($id);
            break;
        default:
            http_response_code(405);
            echo json_encode(["message" => "Método no permitido"]);
    }
}
else {
    print_r($uri);
}
