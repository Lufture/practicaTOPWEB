<?php
require_once (__DIR__ . '/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Model{
    
    var $conn;
    var $tipos;
    var $max_tam;

    function get_max_tam(){
        $this -> max_tam = 1024 *1024;
        return $this -> max_tam;
    }
    function get_tipos(){
        $this->tipos = array('image/jpeg','image/png','image/gif');
        return $this-> tipos;
    }
    function conectar(){
        $this -> conn = new PDO(SGBD.':host='.HOST.';dbname='.DB,USER,PASSWORD);
    }
    
    function alerta($alerta){
        include (__DIR__.'/views/alerta.php');
    }
    function cargarImg(){
        if(isset($_FILES['fotografia'])){
            $imagenes=$_FILES;
            foreach($imagenes as $imagen){
                if($imagen['error']==0){
                    if($imagen['size']<= $this -> get_max_tam() ){
                        if(in_array($imagen['type'], $this-> get_tipos())){
                            $extension = explode('.',$imagen['name']);
                            $extension= $extension[sizeof($extension)-1];                          
                            $nombre = md5($imagen['name'].random_int(1,1000000)).'.'.$extension;
                            if(!file_exists(UPLOAD_DIR.$nombre)){
                                if(move_uploaded_file($imagen['tmp_name'],UPLOAD_DIR.$nombre)){
                                    return $nombre;
                                }
                                return false;
                            }
                        }
                    }
                }
            }
        }else{return false;}
    }
    function validar_correo($correo){
        $expReg = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        return preg_match($expReg, $correo);
    }
    function login($correo, $contrasena){
        $_SESSION['validado'] = false;
        $_SESSION['roles'] = [];
        $_SESSION['permisos'] = [];
        $contrasena = md5($contrasena);
        

        if (!$this->validar_correo($correo)){
            return false;
        }

        $this->conectar();
        $sql = "SELECT * FROM usuario where correo = :correo and contrasena = :contrasena";
        $stmt = $this -> conn -> prepare($sql);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_INT);
        $datos = $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($result){
            $_SESSION['validado'] = true;
            $_SESSION['correo'] = $correo;
            $sql = 'SELECT r.rol from usuario u join usuario_rol using (id_usuario) join rol r using (id_rol) where u.correo = :correo';
            $stmt = $this -> conn -> prepare($sql);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($result as $rol){
                $roles[] = $rol['rol'];
            }
            
            $sql = 'SELECT permiso from usuario u join usuario_rol using (id_usuario) join rol r using (id_rol) join permiso_rol using (id_rol) join permiso using (id_permiso) where u.correo = :correo';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($result as $permiso){
                $permisos[] = $permiso['permiso'];
                
            }

            $_SESSION['roles'] = $roles;
            $_SESSION['permisos'] = $permisos;
            
            
            return true;
        }
    }
    function mandar_correo($destinatario, $asunto, $mensaje, $nombre_destinatario = 'usuario_generico'){
    require (__DIR__.'/../vendor/autoload.php');

    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    
    // REMOVIDO: $mail->SMTPDebug = SMTP::DEBUG_SERVER; - Esto causaba que se mostraran todos los logs
    
    $mail->Host = MAIL_HOST;
    $mail->Port = MAIL_PORT;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    // Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = MAIL_USER;
    //Password to use for SMTP authentication
    $mail->Password = MAIL_PASSWORD;
    //Set who the message is to be sent from
    $mail->setFrom(MAIL_USER, 'Pulidora y Cromadora De Valle');
    //Set who the message is to be sent to
    $mail->addAddress($destinatario, $nombre_destinatario);

    $mail->Subject = $asunto;
    $mail->msgHTML($mensaje);
    
    // Capturar la salida para evitar que se muestre en pantalla
    ob_start();
    $resultado = $mail->send();
    ob_end_clean();
    
    if (!$resultado) {
        // Solo log de error si es necesario para debugging
        error_log('Mailer Error: ' . $mail->ErrorInfo);
        return false;
    } else {
        return true;
    }
}
    
    
    function logout(){
        unset($_SESSION['validado']);
        unset($_SESSION['correo']);
        unset($_SESSION['roles']);
        unset($_SESSION['permisos']);
        session_destroy();
        
        return true;
    }

    function checar($rol){
        if(isset($_SESSION['validado'])){

            $roles = isset($_SESSION['roles']) ? $_SESSION['roles'] : [];
            if(in_array($rol, $roles)){
                return true;
            }
        }

        require_once(__DIR__.'/views/header.php');
        // ob_clean();
        $alerta['mensaje'] = 'NO TIENES PERMISO <a href="login.php">Volver</a>';
        $alerta['tipo'] = 'danger';
        $this->alerta($alerta);
        die();
        header('Location: login.php');
        
        return false;
    }
    
    function checar_permiso($permiso){
        if (isset($_SESSION['validado'])) {
            $permisos = isset($_SESSION['permisos']) ? $_SESSION['permisos'] : [];
            if (in_array($permiso, $permisos)) {
                return true;
            }
        }
        return false;


    }

    function cambiar_contrasena($correo){
        if ($this->validar_correo($correo)) {
            $this->conectar();
            $this->conn->beginTransaction();
            try {
                $sql = "SELECT correo,contrasena FROM usuario WHERE correo = :correo";
                $datos = $this->conn->prepare($sql);
                $datos->bindParam(':correo', $correo, PDO::PARAM_STR);
                $datos->execute();
                $resultado = $datos->fetch(PDO::FETCH_ASSOC);
                if (isset($resultado['correo'])) {
                    $blowfish = 'Visca el Barca' . rand(1, 1000000);
                    $token = md5($blowfish . $resultado['correo']) . md5($resultado['contrasena']);
                    $sql = "UPDATE usuario SET token = :token WHERE correo = :correo";
                    $datos = $this->conn->prepare($sql);
                    $datos->bindParam(':token', $token, PDO::PARAM_STR);
                    $datos->bindParam(':correo', $correo, PDO::PARAM_STR);
                    $datos->execute();
                    $this->conn->commit();
                    return $token;
                }
                $this->conn->rollBack();
                return false;
            } catch (Exception $e) {
                $this->conn->rollBack();
                echo "Error: " . $e->getMessage();
            }
            return false;
        }
    }

    function validar_token($correo,$token){
        $this->conectar();
        $sql = "SELECT correo FROM usuario WHERE correo = :correo AND token = :token";
        $datos = $this->conn->prepare($sql);
        $datos->bindParam(':correo', $correo, PDO::PARAM_STR);
        $datos->bindParam(':token', $token, PDO::PARAM_STR);
        $datos->execute();
        $resultado = $datos->fetch(PDO::FETCH_ASSOC);
        
        if (isset($resultado['correo'])) {
            return true;
        }
        return false;
    }

    function restablecer($correo, $contrasena, $token){
    if(!$this->validar_correo($correo)){
        return false;
    }

    if(!$this->validar_token($correo, $token)){
        return false;
    }

    try {
        $this->conectar();
        $this->conn->beginTransaction();
        
        // Hashear la contraseña (recomiendo usar password_hash en lugar de md5)
        $contrasena = md5($contrasena);
        
        // SQL corregido - quitar el "set" extra
        $sql = "UPDATE usuario SET contrasena = :contrasena, token = null WHERE correo = :correo AND token = :token";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();

        // No necesitas fetch() para UPDATE, solo verificar rowCount
        if ($stmt->rowCount() > 0) {
            $this->conn->commit();
            return true;
        } else {
            $this->conn->rollBack();
            return false;
        }
        
    } catch (PDOException $e) {
        $this->conn->rollBack();
        error_log("Error en restablecer: " . $e->getMessage());
        return false;
    }
    }
}
