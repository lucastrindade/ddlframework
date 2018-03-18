<?php

namespace App\Controllers;

use Core\Route\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $nome = 'teste';
        return $this->view('home.index', compact('nome'), 'default');
    }
}