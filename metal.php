<?php
require_once(__DIR__.'/models/metal.php');
$web = new Metal();
$accion = isset($_GET['accion']) ? $_GET['accion']:null;
$id=isset($_GET['id']) ? $_GET['id']:null;
$alerta =[];
require_once(__DIR__.'/views/header.php');

switch ($accion){
    case 'crear':
        if (isset($_POST['enviar'])) {
            $datos = $_POST['datos'];
            $resultado = $web->crear($datos);
            if ($resultado) {
                $alerta['mensaje'] = 'Exito: El metal se guardó correctamente';
                $alerta['tipo'] = 'success';
            } else {
                $alerta['mensaje'] = 'Error: El metal no se guardó';
                $alerta['tipo'] = 'danger';
                $web->alerta($alerta);
                require_once(__DIR__ . '/views/metal/form.php');
                break;
            }
            $web->alerta($alerta);
            $metales = $web->leer();
            require_once(__DIR__ . '/views/metal/index.php');
        } else {
            require_once(__DIR__ . '/views/metal/form.php');
        }
        
        break;
    case 'modificar':
        $info= null;
        $info = $web->leerUno($id);
        if (isset($_POST['enviar'])) {
            $datos = $_POST['datos'];
            $resultado = $web->modificar($datos, $id);
            if ($resultado) {
                $alerta['mensaje'] = 'Exito: EL metal se actualizó correctamente';
                $alerta['tipo'] = 'success';
            } else {
                $alerta['mensaje'] = 'Error: El metal no se actualizó';
                $alerta['tipo'] = 'danger';
            }
            $web->alerta($alerta);
            $metales = $web->leer();
            require_once(__DIR__ . '/views/metal/index.php');
        } else {
            require_once(__DIR__ . '/views/metal/form.php');
        }
        break;
    case 'eliminar':
        $resultado = $web -> eliminar($id);
        if ($resultado) {
            $alerta['mensaje']='metal eliminado correctamente';
            $alerta['tipo']='success';
        }else {
            $alerta['mensaje']='No se pude eliminar el metal';
            $alerta['tipo']='danger';
        }
        $web -> alerta($alerta);
        $metales= $web -> leer();
        require_once(__DIR__.'/views/metal/index.php');
        break;
    case 'leer':
        default:
        $metales = $web->leer();
        require_once(__DIR__.'/views/metal/index.php');
}
require_once(__DIR__.'/views/footer.php');