<?php

class Partido {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getTotalMatches() {
        $this->db->query('SELECT id FROM partidos');
        $this->db->execute();
        return $this->db->rowCount();
    }
}
