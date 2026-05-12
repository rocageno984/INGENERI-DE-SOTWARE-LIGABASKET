<?php

class Stats extends Controller {
    private $teamModel;

    public function __construct() {
        $this->teamModel = $this->model('Team');
    }

    public function index() {
        $standings = $this->teamModel->getStandings();
        
        // Load matches for the bracket
        $matchModel = $this->model('Partido');
        $allMatches = $matchModel->getMatches();
        
        $bracket = [
            'Octavos' => [],
            'Cuartos' => [],
            'Semis' => [],
            'Final' => []
        ];

        foreach ($allMatches as $match) {
            if (isset($bracket[$match->fase])) {
                $bracket[$match->fase][] = $match;
            }
        }

        $data = [
            'title' => 'Estadísticas y Play-offs',
            'standings' => $standings,
            'bracket' => $bracket,
            'totalTeams' => count($standings),
            'active' => 'stats'
        ];

        $this->view('stats/index', $data);
    }
}
