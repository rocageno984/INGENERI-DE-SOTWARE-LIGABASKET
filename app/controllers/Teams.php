<?php

class Teams extends Controller {
    private $teamModel;

    public function __construct() {
        $this->teamModel = $this->model('Team');
    }

    public function index() {
        // Get teams
        $teams = $this->teamModel->getTeams();

        $data = [
            'title' => 'Equipos de la Liga',
            'teams' => $teams
        ];

        $this->view('teams/index', $data);
    }

    public function add() {
        $data = [
            'title' => 'Agregar Equipo'
        ];

        $this->view('teams/add', $data);
    }
}
