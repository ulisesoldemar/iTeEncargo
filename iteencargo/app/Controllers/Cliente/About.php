<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;

// Mismo nombre del archivo
class About extends BaseController
{

    public function index()
    {
        echo view('cliente/about');
    }
}
