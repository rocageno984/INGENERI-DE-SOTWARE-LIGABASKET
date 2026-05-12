<?php

class Player {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getPlayers() {
        $this->db->query('SELECT j.*, e.nombre as nombre_equipo 
                          FROM jugadores j 
                          JOIN equipos e ON j.id_equipo = e.id 
                          ORDER BY j.id_equipo, j.nombre ASC');
        return $this->db->resultSet();
    }

    public function getPlayersByTeam($team_id) {
        $this->db->query('SELECT * FROM jugadores WHERE id_equipo = :id_equipo ORDER BY nombre ASC');
        $this->db->bind(':id_equipo', $team_id);
        return $this->db->resultSet();
    }

    public function addPlayer($data) {
        $this->db->query('INSERT INTO jugadores (id_equipo, nombre, apellido, posicion, numero_camiseta) 
                          VALUES (:id_equipo, :nombre, :apellido, :posicion, :numero_camiseta)');
        $this->db->bind(':id_equipo', $data['id_equipo']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':apellido', $data['apellido']);
        $this->db->bind(':posicion', $data['posicion']);
        $this->db->bind(':numero_camiseta', $data['numero_camiseta']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getPlayerById($id) {
        $this->db->query('SELECT * FROM jugadores WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updatePlayer($data) {
        $this->db->query('UPDATE jugadores 
                          SET id_equipo = :id_equipo, nombre = :nombre, apellido = :apellido, 
                              posicion = :posicion, numero_camiseta = :numero_camiseta 
                          WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':id_equipo', $data['id_equipo']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':apellido', $data['apellido']);
        $this->db->bind(':posicion', $data['posicion']);
        $this->db->bind(':numero_camiseta', $data['numero_camiseta']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePlayer($id) {
        $this->db->query('DELETE FROM jugadores WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTotalPlayers() {
        $this->db->query('SELECT id FROM jugadores');
        $this->db->execute();
        return $this->db->rowCount();
    }
}
