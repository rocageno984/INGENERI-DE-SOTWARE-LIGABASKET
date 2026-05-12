<?php

class Matches extends Controller {
    private $matchModel;
    private $teamModel;

    public function __construct() {
        $this->matchModel = $this->model('Partido');
        $this->teamModel = $this->model('Team');
    }

    public function index() {
        $allMatches = $this->matchModel->getMatches();
        $now = date('Y-m-d H:i:s');
        
        $upcomingMatches = [];
        $pastMatches = [];

        foreach ($allMatches as $match) {
            if ($match->fecha_partido >= $now) {
                $upcomingMatches[] = $match;
            } else {
                $pastMatches[] = $match;
            }
        }

        $data = [
            'title' => 'Calendario de Partidos',
            'upcomingMatches' => array_reverse($upcomingMatches), // Show soonest first
            'pastMatches' => $pastMatches, // Show recent first
            'active' => 'matches'
        ];

        $this->view('matches/index', $data);
    }

    public function add() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id_equipo_local' => trim($_POST['id_equipo_local']),
                'id_equipo_visitante' => trim($_POST['id_equipo_visitante']),
                'fecha_partido' => trim($_POST['fecha_partido']),
                'puntos_local' => trim($_POST['puntos_local']),
                'puntos_visitante' => trim($_POST['puntos_visitante']),
                'estado' => trim($_POST['estado']),
                'fase' => trim($_POST['fase']),
                'title' => 'Programar Partido',
                'active' => 'matches',
                'errors' => []
            ];

            // Validation
            if (empty($data['id_equipo_local'])) $data['errors']['id_equipo_local'] = 'Seleccione equipo local.';
            if (empty($data['id_equipo_visitante'])) $data['errors']['id_equipo_visitante'] = 'Seleccione equipo visitante.';
            if ($data['id_equipo_local'] == $data['id_equipo_visitante']) {
                $data['errors']['id_equipo_visitante'] = 'Los equipos no pueden ser iguales.';
            }
            if (empty($data['fecha_partido'])) $data['errors']['fecha_partido'] = 'Seleccione fecha.';

            if (empty($data['errors'])) {
                if ($this->matchModel->addMatch($data)) {
                    flash('match_message', 'Partido programado correctamente');
                    redirect('matches');
                } else {
                    die('Algo salió mal.');
                }
            } else {
                $data['teams'] = $this->teamModel->getTeams();
                $this->view('matches/add', $data);
            }
        } else {
            $teams = $this->teamModel->getTeams();
            $data = [
                'id_equipo_local' => '',
                'id_equipo_visitante' => '',
                'fecha_partido' => '',
                'puntos_local' => 0,
                'puntos_visitante' => 0,
                'estado' => 'Programado',
                'fase' => 'Regular',
                'teams' => $teams,
                'title' => 'Programar Partido',
                'active' => 'matches',
                'errors' => []
            ];

            $this->view('matches/add', $data);
        }
    }

    public function edit($id) {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'id_equipo_local' => trim($_POST['id_equipo_local']),
                'id_equipo_visitante' => trim($_POST['id_equipo_visitante']),
                'fecha_partido' => trim($_POST['fecha_partido']),
                'puntos_local' => trim($_POST['puntos_local']),
                'puntos_visitante' => trim($_POST['puntos_visitante']),
                'estado' => trim($_POST['estado']),
                'fase' => trim($_POST['fase']),
                'title' => 'Editar Partido',
                'active' => 'matches',
                'errors' => []
            ];

            if (empty($data['errors'])) {
                if ($this->matchModel->updateMatch($data)) {
                    flash('match_message', 'Partido actualizado');
                    redirect('matches');
                } else {
                    die('Algo salió mal.');
                }
            } else {
                $data['teams'] = $this->teamModel->getTeams();
                $this->view('matches/edit', $data);
            }
        } else {
            $match = $this->matchModel->getMatchById($id);
            $teams = $this->teamModel->getTeams();

            $data = [
                'id' => $id,
                'id_equipo_local' => $match->id_equipo_local,
                'id_equipo_visitante' => $match->id_equipo_visitante,
                'fecha_partido' => date('Y-m-d\TH:i', strtotime($match->fecha_partido)),
                'puntos_local' => $match->puntos_local,
                'puntos_visitante' => $match->puntos_visitante,
                'estado' => $match->estado,
                'fase' => $match->fase,
                'teams' => $teams,
                'title' => 'Editar Partido',
                'active' => 'matches',
                'errors' => []
            ];

            $this->view('matches/edit', $data);
        }
    }

    public function delete($id) {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->matchModel->deleteMatch($id)) {
                flash('match_message', 'Partido eliminado', 'danger');
                redirect('matches');
            } else {
                die('Algo salió mal.');
            }
        } else {
            redirect('matches');
        }
    }
}
