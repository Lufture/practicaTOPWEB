<?php
session_start();
define('SGBD','mysql');
define('HOST','localhost');
define('DB','sakila');
define('USER','root');
define('PASSWORD','');
define('UPLOAD_DIR','C:\\xampp\\htdocs\\proyectos\\sakila_app\\uploads\\');
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 465);
define('MAIL_USER','tu_email@gmail.com');
define('MAIL_PASSWORD','tu_password');

class Database {
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                SGBD . ":host=" . HOST . ";dbname=" . DB,
                USER,
                PASSWORD
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>