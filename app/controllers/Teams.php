<?php

class Teams extends Controller {
    private $teamModel;

    public function __construct() {
        $this->teamModel = $this->model('Team');
    }

    public function index() {
        // Get teams
        $teams = $this->teamModel->getTeams();
        
        // Load Player model to get players for each team
        $playerModel = $this->model('Player');
        foreach ($teams as $team) {
            $team->players = $playerModel->getPlayersByTeam($team->id);
        }

        $data = [
            'title' => 'Equipos de la Liga',
            'teams' => $teams,
            'active' => 'teams'
        ];

        $this->view('teams/index', $data);
    }

    public function add() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'nombre' => trim($_POST['nombre']),
                'ciudad' => trim($_POST['ciudad']),
                'nombre_entrenador' => trim($_POST['nombre_entrenador']),
                'title' => 'Agregar Equipo',
                'active' => 'teams',
                'errors' => []
            ];

            // Validate
            if (empty($data['nombre'])) {
                $data['errors']['nombre'] = 'Ingrese el nombre del equipo.';
            }
            if (empty($data['ciudad'])) {
                $data['errors']['ciudad'] = 'Ingrese la ciudad.';
            }

            if (empty($data['errors'])) {
                if ($this->teamModel->addTeam($data)) {
                    flash('team_message', 'Equipo agregado correctamente');
                    redirect('teams');
                } else {
                    die('Algo salió mal.');
                }
            } else {
                $this->view('teams/add', $data);
            }
        } else {
            $data = [
                'nombre' => '',
                'ciudad' => '',
                'nombre_entrenador' => '',
                'title' => 'Agregar Equipo',
                'active' => 'teams',
                'errors' => []
            ];

            $this->view('teams/add', $data);
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
                'nombre' => trim($_POST['nombre']),
                'ciudad' => trim($_POST['ciudad']),
                'nombre_entrenador' => trim($_POST['nombre_entrenador']),
                'title' => 'Editar Equipo',
                'active' => 'teams',
                'errors' => []
            ];

            // Validate
            if (empty($data['nombre'])) {
                $data['errors']['nombre'] = 'Ingrese el nombre del equipo.';
            }
            if (empty($data['ciudad'])) {
                $data['errors']['ciudad'] = 'Ingrese la ciudad.';
            }

            if (empty($data['errors'])) {
                if ($this->teamModel->updateTeam($data)) {
                    flash('team_message', 'Equipo actualizado');
                    redirect('teams');
                } else {
                    die('Algo salió mal.');
                }
            } else {
                $this->view('teams/edit', $data);
            }
        } else {
            // Get existing team
            $team = $this->teamModel->getTeamById($id);

            $data = [
                'id' => $id,
                'nombre' => $team->nombre,
                'ciudad' => $team->ciudad,
                'nombre_entrenador' => $team->nombre_entrenador,
                'title' => 'Editar Equipo',
                'active' => 'teams',
                'errors' => []
            ];

            $this->view('teams/edit', $data);
        }
    }

    public function delete($id) {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->teamModel->deleteTeam($id)) {
                flash('team_message', 'Equipo eliminado');
                redirect('teams');
            } else {
                die('Algo salió mal.');
            }
        } else {
            redirect('teams');
        }
    }
}
