<?php

class Team {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getTeams() {
        $this->db->query('SELECT * FROM equipos ORDER BY nombre ASC');
        return $this->db->resultSet();
    }

    public function addTeam($data) {
        $this->db->query('INSERT INTO equipos (nombre, ciudad, nombre_entrenador) VALUES (:nombre, :ciudad, :nombre_entrenador)');
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':ciudad', $data['ciudad']);
        $this->db->bind(':nombre_entrenador', $data['nombre_entrenador']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTeamById($id) {
        $this->db->query('SELECT * FROM equipos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}
