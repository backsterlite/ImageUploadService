<?php


namespace App\controllers;


use App\models\Database;
use Delight\Auth\Auth;
use League\Plates\Engine;

class Controller
{

    protected $view;

    protected $auth;

    protected $database;

    public function __construct()
    {

        $this->view = components(Engine::class);
        $this->auth = components(Auth::class);
        $this->database = components(Database::class);
    }
}