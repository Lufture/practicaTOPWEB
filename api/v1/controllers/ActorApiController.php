<?php

require_once __DIR__ . '../../../../config.php';
require_once __DIR__.'../../../../models/Actor.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class ActorApiController {
    private $db;
    private $actor;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->actor = new Actor($this->db);
    }

    public function index() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        if (!empty($search)) {
            $stmt = $this->actor->search($search);
        } else {
            $stmt = $this->actor->read();
        }

        $actors = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $actors[] = $row;
        }

        echo json_encode($actors);
    }

    public function show($id) {
        $this->actor->actor_id = $id;
        if ($this->actor->readOne()) {
            echo json_encode([
                "id" => $this->actor->actor_id,
                "first_name" => $this->actor->first_name,
                "last_name" => $this->actor->last_name
            ]);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Actor no encontrado"]);
        }
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->first_name) || empty($data->last_name)) {
            http_response_code(400);
            echo json_encode(["message" => "Todos los campos son obligatorios"]);
            return;
        }

        $this->actor->first_name = $data->first_name;
        $this->actor->last_name = $data->last_name;

        if ($this->actor->create()) {
            http_response_code(201);
            echo json_encode(["message" => "Actor creado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error al crear el actor"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"));
        $this->actor->actor_id = $id;

        if (empty($data->first_name) || empty($data->last_name)) {
            http_response_code(400);
            echo json_encode(["message" => "Todos los campos son obligatorios"]);
            return;
        }

        $this->actor->first_name = $data->first_name;
        $this->actor->last_name = $data->last_name;

        if ($this->actor->update()) {
            echo json_encode(["message" => "Actor actualizado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error al actualizar el actor"]);
        }
    }

    public function delete($id) {
        $this->actor->actor_id = $id;

        if ($this->actor->delete()) {
            echo json_encode(["message" => "Actor eliminado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error al eliminar el actor"]);
        }
    }
}
