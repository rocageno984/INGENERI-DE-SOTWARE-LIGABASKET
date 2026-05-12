<?php

class Matches extends Controller {
    public function __construct() {
        // Model initialization if needed
    }

    public function index() {
        $data = [
            'title' => 'Calendario de Partidos'
        ];

        $this->view('matches/index', $data);
    }
}
