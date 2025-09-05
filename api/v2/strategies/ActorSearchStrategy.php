<?php
interface ActorSearchStrategy {
    public function search($conn, $keywords);
}
