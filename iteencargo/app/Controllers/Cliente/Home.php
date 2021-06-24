<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;

class Home extends BaseController
{
	public function index()
	{
		echo view('cliente/home');
	}

}
