<?php
require_once "ActorSearchStrategy.php";

class SearchByLastName implements ActorSearchStrategy {
    public function search($conn, $keywords) {
        $query = "SELECT actor_id, first_name, last_name, last_update 
                  FROM actor 
                  WHERE last_name LIKE ? 
                  ORDER BY last_name, first_name";
        $stmt = $conn->prepare($query);
        $like = "%{$keywords}%";
        $stmt->bindParam(1, $like);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
