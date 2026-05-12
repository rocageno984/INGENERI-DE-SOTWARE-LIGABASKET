<?php

class Users extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function login() {
        $data = [
            'title' => 'Iniciar Sesión'
        ];

        $this->view('users/login', $data);
    }

    public function register() {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'nombre' => trim($_POST['nombre']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'title' => 'Crear Cuenta',
                'errors' => []
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['errors']['email'] = 'Por favor ingrese un correo.';
            } else {
                // Check email
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['errors']['email'] = 'El correo ya está registrado.';
                }
            }

            // Validate Name
            if (empty($data['nombre'])) {
                $data['errors']['nombre'] = 'Por favor ingrese su nombre.';
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['errors']['password'] = 'Por favor ingrese una contraseña.';
            } elseif (strlen($data['password']) < 6) {
                $data['errors']['password'] = 'La contraseña debe tener al menos 6 caracteres.';
            }

            // Validate Confirm Password
            if (empty($data['confirm_password'])) {
                $data['errors']['confirm_password'] = 'Por favor confirme su contraseña.';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['errors']['confirm_password'] = 'Las contraseñas no coinciden.';
                }
            }

            // Make sure errors are empty
            if (empty($data['errors'])) {
                // Validated
                
                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if ($this->userModel->register($data)) {
                    redirect('users/login');
                } else {
                    die('Algo salió mal.');
                }

            } else {
                // Load view with errors
                $this->view('users/register', $data);
            }

        } else {
            // Init data
            $data = [
                'nombre' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'title' => 'Crear Cuenta',
                'errors' => []
            ];

            // Load view
            $this->view('users/register', $data);
        }
    }
}
