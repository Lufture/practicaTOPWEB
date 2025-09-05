<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../repositories/ActorRepository.php';
require_once __DIR__ . '/../strategies/ActorSearchStrategy.php';
require_once __DIR__ . '/../strategies/SearchByName.php';
require_once __DIR__ . '/../strategies/SearchByLastName.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class ActorApiController {
    private $db;
    private $repository;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->repository = new ActorRepository($this->db);
    }

    public function index() {
        $search = $_GET['search'] ?? '';
        $strategy = $_GET['strategy'] ?? 'name'; 

        if (!empty($search)) {
            switch ($strategy) {
                case 'lastname':
                    $searchStrategy = new SearchByLastName();
                    break;
                case 'name':
                default:
                    $searchStrategy = new SearchByName();
                    break;
            }
            $actors = $searchStrategy->search($this->db, $search);
        } else {
            $actors = $this->repository->getAll();
        }

        echo json_encode($actors);
    }

    public function show($id) {
        $actor = $this->repository->getById($id);
        if ($actor) {
            echo json_encode($actor);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Actor no encontrado"]);
        }
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (empty($data['first_name']) || empty($data['last_name'])) {
            http_response_code(400);
            echo json_encode(["message" => "Todos los campos son obligatorios"]);
            return;
        }
        if ($this->repository->create($data['first_name'], $data['last_name'])) {
            http_response_code(201);
            echo json_encode(["message" => "Actor creado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error al crear el actor"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (empty($data['first_name']) || empty($data['last_name'])) {
            http_response_code(400);
            echo json_encode(["message" => "Todos los campos son obligatorios"]);
            return;
        }
        if ($this->repository->update($id, $data['first_name'], $data['last_name'])) {
            echo json_encode(["message" => "Actor actualizado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error al actualizar el actor"]);
        }
    }

    public function delete($id) {
        if ($this->repository->delete($id)) {
            echo json_encode(["message" => "Actor eliminado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error al eliminar el actor"]);
        }
    }
}
