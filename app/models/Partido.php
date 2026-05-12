<?php

class Partido {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getMatches() {
        $this->db->query('SELECT p.*, 
                          t1.nombre as equipo_local, 
                          t2.nombre as equipo_visitante 
                          FROM partidos p 
                          JOIN equipos t1 ON p.id_equipo_local = t1.id 
                          JOIN equipos t2 ON p.id_equipo_visitante = t2.id 
                          ORDER BY p.fecha_partido DESC');
        return $this->db->resultSet();
    }

    public function addMatch($data) {
        $this->db->query('INSERT INTO partidos (id_equipo_local, id_equipo_visitante, fecha_partido, puntos_local, puntos_visitante, estado, fase) 
                          VALUES (:id_equipo_local, :id_equipo_visitante, :fecha_partido, :puntos_local, :puntos_visitante, :estado, :fase)');
        $this->db->bind(':id_equipo_local', $data['id_equipo_local']);
        $this->db->bind(':id_equipo_visitante', $data['id_equipo_visitante']);
        $this->db->bind(':fecha_partido', $data['fecha_partido']);
        $this->db->bind(':puntos_local', $data['puntos_local'] ?: 0);
        $this->db->bind(':puntos_visitante', $data['puntos_visitante'] ?: 0);
        $this->db->bind(':estado', $data['estado'] ?: 'Programado');
        $this->db->bind(':fase', $data['fase'] ?: 'Regular');

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getMatchById($id) {
        $this->db->query('SELECT * FROM partidos WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateMatch($data) {
        $this->db->query('UPDATE partidos 
                          SET id_equipo_local = :id_equipo_local, 
                              id_equipo_visitante = :id_equipo_visitante, 
                              fecha_partido = :fecha_partido, 
                              puntos_local = :puntos_local, 
                              puntos_visitante = :puntos_visitante, 
                              estado = :estado,
                              fase = :fase 
                          WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':id_equipo_local', $data['id_equipo_local']);
        $this->db->bind(':id_equipo_visitante', $data['id_equipo_visitante']);
        $this->db->bind(':fecha_partido', $data['fecha_partido']);
        $this->db->bind(':puntos_local', $data['puntos_local']);
        $this->db->bind(':puntos_visitante', $data['puntos_visitante']);
        $this->db->bind(':estado', $data['estado']);
        $this->db->bind(':fase', $data['fase']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteMatch($id) {
        $this->db->query('DELETE FROM partidos WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTotalMatches() {
        $this->db->query('SELECT id FROM partidos');
        $this->db->execute();
        return $this->db->rowCount();
    }
}
