<?php
class ActorRepository {
    private $conn;
    private $table_name = "actor";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT actor_id, first_name, last_name, last_update 
                  FROM {$this->table_name} 
                  ORDER BY last_name, first_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT actor_id, first_name, last_name, last_update 
                  FROM {$this->table_name} 
                  WHERE actor_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($first_name, $last_name) {
        $query = "INSERT INTO {$this->table_name} 
                  (first_name, last_name, last_update) 
                  VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$first_name, $last_name]);
    }

    public function update($id, $first_name, $last_name) {
        $query = "UPDATE {$this->table_name} 
                  SET first_name = ?, last_name = ?, last_update = NOW() 
                  WHERE actor_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$first_name, $last_name, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table_name} WHERE actor_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
