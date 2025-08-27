<?php
require_once '../config.php';
require_once '../models/Actor.php';

class ActorController {
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
            $page_title = "Resultados de búsqueda: " . htmlspecialchars($search);
        } else {
            $stmt = $this->actor->read();
            $page_title = "Lista de Actores";
        }

        include_once '../views/actors/index.php';
    }

    public function show($id) {
        $this->actor->actor_id = $id;
        if($this->actor->readOne()) {
            $page_title = "Actor: " . $this->actor->first_name . " " . $this->actor->last_name;
            include_once '../views/actors/show.php';
        } else {
            header("Location: index.php?error=Actor no encontrado");
        }
    }
}
?>