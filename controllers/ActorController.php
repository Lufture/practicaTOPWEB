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

    public function delete($id) {
        $this->actor->actor_id = $id;
        
        // Primero obtenemos los datos del actor para mostrar un mensaje personalizado
        $actor_name = "";
        if($this->actor->readOne()) {
            $actor_name = $this->actor->first_name . " " . $this->actor->last_name;
        }
        
        // Intentamos eliminar el actor
        if($this->actor->delete()) {
            $message = !empty($actor_name) ? "Actor '{$actor_name}' eliminado exitosamente" : "Actor eliminado exitosamente";
            header("Location: index.php?success=" . urlencode($message));
        } else {
            header("Location: index.php?error=Error al eliminar el actor");
        }
        exit();
    }
    public function edit($id) {
        $this->actor->actor_id = $id;
        if($this->actor->readOne()) {
            $page_title = "Editar Actor: " . $this->actor->first_name . " " . $this->actor->last_name;
            include_once '../views/actors/edit.php';
        } else {
            header("Location: index.php?error=Actor no encontrado");
            exit();
        }
    }
    public function update($id) {
        if($_POST) {
            $this->actor->actor_id = $id;
            $this->actor->first_name = $_POST['first_name'];
            $this->actor->last_name = $_POST['last_name'];
            
            // Validaciones básicas
            if(empty(trim($this->actor->first_name)) || empty(trim($this->actor->last_name))) {
                header("Location: index.php?action=edit&id={$id}&error=Todos los campos son obligatorios");
                exit();
            }
            
            // Validar longitud máxima (según estructura típica de base de datos)
            if(strlen($this->actor->first_name) > 45 || strlen($this->actor->last_name) > 45) {
                header("Location: index.php?action=edit&id={$id}&error=Los nombres no pueden exceder 45 caracteres");
                exit();
            }
            
            if($this->actor->update()) {
                $message = "Actor '{$this->actor->first_name} {$this->actor->last_name}' actualizado exitosamente";
                header("Location: index.php?success=" . urlencode($message));
            } else {
                header("Location: index.php?action=edit&id={$id}&error=Error al actualizar el actor");
            }
            exit();
        } else {
            // Si no hay datos POST, redirigir al formulario de edición
            $this->edit($id);
        }
    }

    public function create() {
        $page_title = "Crear Nuevo Actor";
        include_once '../views/actors/create.php';
    }
}
?>