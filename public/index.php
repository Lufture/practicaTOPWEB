<?php
// Punto de entrada principal de la aplicación
require_once '../controllers/ActorController.php';

// Determinar la acción a realizar
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Crear instancia del controlador
$controller = new ActorController();

// Ejecutar la acción correspondiente
switch($action) {
    case 'show':
        if($id) {
            $controller->show($id);
        } else {
            header("Location: index.php?error=ID de actor requerido");
        }
        break;
    case 'delete':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if($id > 0) {
            $controller->delete($id);
        } else {
            header("Location: index.php?error=ID inválido");
        }
        break;
    case 'edit':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if($id > 0) {
            $controller->edit($id);
        } else {
            header("Location: index.php?error=ID inválido");
        }
        break;
        
    case 'update':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if($id > 0) {
            $controller->update($id);
        } else {
            header("Location: index.php?error=ID inválido");
        }
        break;
    
    case 'index':
    default:
        $controller->index();
        break;
}
?>