<?php

class Players extends Controller {
    private $playerModel;
    private $teamModel;

    public function __construct() {
        $this->playerModel = $this->model('Player');
        $this->teamModel = $this->model('Team');
    }

    public function index() {
        $players = $this->playerModel->getPlayers();

        $data = [
            'title' => 'Gestión de Jugadores',
            'players' => $players,
            'active' => 'players'
        ];

        $this->view('players/index', $data);
    }

    public function add($team_id = null) {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id_equipo' => trim($_POST['id_equipo']),
                'nombre' => trim($_POST['nombre']),
                'apellido' => trim($_POST['apellido']),
                'posicion' => trim($_POST['posicion']),
                'numero_camiseta' => trim($_POST['numero_camiseta']),
                'title' => 'Agregar Jugador',
                'active' => 'players',
                'errors' => []
            ];

            // Simple validation
            if (empty($data['nombre'])) $data['errors']['nombre'] = 'Ingrese el nombre.';
            if (empty($data['id_equipo'])) $data['errors']['id_equipo'] = 'Seleccione un equipo.';

            if (empty($data['errors'])) {
                if ($this->playerModel->addPlayer($data)) {
                    flash('player_message', 'Jugador registrado correctamente');
                    redirect('players');
                } else {
                    die('Algo salió mal.');
                }
            } else {
                $data['teams'] = $this->teamModel->getTeams();
                $this->view('players/add', $data);
            }
        } else {
            $teams = $this->teamModel->getTeams();
            $data = [
                'id_equipo' => $team_id, // Pre-select team ID if provided
                'nombre' => '',
                'apellido' => '',
                'posicion' => '',
                'numero_camiseta' => '',
                'teams' => $teams,
                'title' => 'Agregar Jugador',
                'active' => 'players',
                'errors' => []
            ];

            $this->view('players/add', $data);
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
                'id_equipo' => trim($_POST['id_equipo']),
                'nombre' => trim($_POST['nombre']),
                'apellido' => trim($_POST['apellido']),
                'posicion' => trim($_POST['posicion']),
                'numero_camiseta' => trim($_POST['numero_camiseta']),
                'title' => 'Editar Jugador',
                'active' => 'players',
                'errors' => []
            ];

            if (empty($data['errors'])) {
                if ($this->playerModel->updatePlayer($data)) {
                    flash('player_message', 'Jugador actualizado');
                    redirect('players');
                } else {
                    die('Algo salió mal.');
                }
            } else {
                $data['teams'] = $this->teamModel->getTeams();
                $this->view('players/edit', $data);
            }
        } else {
            $player = $this->playerModel->getPlayerById($id);
            $teams = $this->teamModel->getTeams();

            $data = [
                'id' => $id,
                'id_equipo' => $player->id_equipo,
                'nombre' => $player->nombre,
                'apellido' => $player->apellido,
                'posicion' => $player->posicion,
                'numero_camiseta' => $player->numero_camiseta,
                'teams' => $teams,
                'title' => 'Editar Jugador',
                'active' => 'players',
                'errors' => []
            ];

            $this->view('players/edit', $data);
        }
    }

    public function delete($id) {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->playerModel->deletePlayer($id)) {
                flash('player_message', 'Jugador eliminado', 'danger');
                redirect('players');
            } else {
                die('Algo salió mal.');
            }
        } else {
            redirect('players');
        }
    }
}
