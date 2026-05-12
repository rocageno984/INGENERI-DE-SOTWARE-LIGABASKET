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

    public function getTotalTeams() {
        $this->db->query('SELECT id FROM equipos');
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateTeam($data) {
        $this->db->query('UPDATE equipos SET nombre = :nombre, ciudad = :ciudad, nombre_entrenador = :nombre_entrenador WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':nombre', $data['nombre']);
        $this->db->bind(':ciudad', $data['ciudad']);
        $this->db->bind(':nombre_entrenador', $data['nombre_entrenador']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteTeam($id) {
        $this->db->query('DELETE FROM equipos WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getStandings() {
        // This query calculates standings based on 'Finalizado' matches
        $this->db->query("
            SELECT 
                t.id, 
                t.nombre, 
                COUNT(p.id) as PJ,
                SUM(CASE 
                    WHEN (p.id_equipo_local = t.id AND p.puntos_local > p.puntos_visitante) OR 
                         (p.id_equipo_visitante = t.id AND p.puntos_visitante > p.puntos_local) THEN 1 
                    ELSE 0 END) as PG,
                SUM(CASE 
                    WHEN (p.id_equipo_local = t.id AND p.puntos_local < p.puntos_visitante) OR 
                         (p.id_equipo_visitante = t.id AND p.puntos_visitante < p.puntos_local) THEN 1 
                    ELSE 0 END) as PP,
                SUM(CASE WHEN p.id_equipo_local = t.id THEN p.puntos_local ELSE p.puntos_visitante END) as PF,
                SUM(CASE WHEN p.id_equipo_local = t.id THEN p.puntos_visitante ELSE p.puntos_local END) as PC,
                (IFNULL(SUM(CASE WHEN p.id_equipo_local = t.id THEN p.puntos_local ELSE p.puntos_visitante END), 0) - 
                 IFNULL(SUM(CASE WHEN p.id_equipo_local = t.id THEN p.puntos_visitante ELSE p.puntos_local END), 0)) as DIF,
                (SUM(CASE 
                    WHEN (p.id_equipo_local = t.id AND p.puntos_local > p.puntos_visitante) OR 
                         (p.id_equipo_visitante = t.id AND p.puntos_visitante > p.puntos_local) THEN 2 
                    WHEN p.id IS NOT NULL THEN 1
                    ELSE 0 END)) as PTS
            FROM equipos t
            LEFT JOIN partidos p ON (t.id = p.id_equipo_local OR t.id = p.id_equipo_visitante) AND p.estado = 'Finalizado'
            GROUP BY t.id
            ORDER BY PTS DESC, DIF DESC
        ");

        return $this->db->resultSet();
    }
}

