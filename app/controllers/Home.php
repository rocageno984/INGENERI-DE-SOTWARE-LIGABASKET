<?php

class Home extends Controller {
    public function __construct() {
        // Model initialization if needed
    }

    public function index() {
        $data = [
            'title' => 'Bienvenido a la Liga Pro',
            'description' => 'La mejor plataforma para gestionar tu liga de básquetbol.'
        ];

        $this->view('home/index', $data);
    }
}
