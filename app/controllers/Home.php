<?php

class Home extends Controller {
    private $teamModel;
    private $playerModel;
    private $matchModel;

    public function __construct() {
        $this->teamModel = $this->model('Team');
        $this->playerModel = $this->model('Player');
        $this->matchModel = $this->model('Partido');
    }

    public function index() {
        $totalTeams = $this->teamModel->getTotalTeams();
        $totalPlayers = $this->playerModel->getTotalPlayers();
        $totalMatches = $this->matchModel->getTotalMatches();

        $data = [
            'title' => 'Bienvenido a la Liga Pro',
            'description' => 'La mejor plataforma para gestionar tu liga de básquetbol.',
            'totalTeams' => $totalTeams,
            'totalPlayers' => $totalPlayers,
            'totalMatches' => $totalMatches,
            'active' => 'home'
        ];

        $this->view('home/index', $data);
    }
}
