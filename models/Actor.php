<?php
class Actor {
    private $conn;
    private $table_name = "actor";

    public $actor_id;
    public $first_name;
    public $last_name;
    public $last_update;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los actores
    public function read() {
        $query = "SELECT actor_id, first_name, last_name, last_update FROM " . $this->table_name . " ORDER BY last_name, first_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener un actor por ID
    public function readOne() {
        $query = "SELECT actor_id, first_name, last_name, last_update FROM " . $this->table_name . " WHERE actor_id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->actor_id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->last_update = $row['last_update'];
            return true;
        }
        return false;
    }
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE actor_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->actor_id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Buscar actores por nombre
    public function search($keywords) {
        $query = "SELECT actor_id, first_name, last_name, last_update FROM " . $this->table_name . " 
                  WHERE first_name LIKE ? OR last_name LIKE ? 
                  ORDER BY last_name, first_name";
        
        $stmt = $this->conn->prepare($query);
        $keywords = "%{$keywords}%";
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->execute();
        
        return $stmt;
    }
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET first_name = ?, last_name = ?, last_update = NOW() 
                  WHERE actor_id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        // Limpiar los datos
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->actor_id = htmlspecialchars(strip_tags($this->actor_id));
        
        // Vincular los parámetros
        $stmt->bindParam(1, $this->first_name);
        $stmt->bindParam(2, $this->last_name);
        $stmt->bindParam(3, $this->actor_id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>