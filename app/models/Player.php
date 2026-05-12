<?php

class Player {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getTotalPlayers() {
        $this->db->query('SELECT id FROM jugadores');
        $this->db->execute();
        return $this->db->rowCount();
    }
}
