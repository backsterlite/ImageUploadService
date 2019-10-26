<?php


namespace App\controllers;


use Delight\Auth\Auth;
use League\Plates\Engine;

class Controller
{

    protected $view;

    protected $auth;

    public function __construct(Engine $view, Auth $auth)
    {

        $this->view = $view;
        $this->auth = $auth;
    }
}