<?php


namespace App\controllers;


use App\models\Database;
use League\Plates\Engine;

class HomeController
{

    /**
     * @var Engine
     */
    private $view;
    /**
     * @var Database
     */
    private $database;

    public function __construct(Engine $view, Database $database)
    {


        $this->view = $view;
        $this->database = $database;
    }

    public function index()
    {
        $photos = $this->database->all('photo', 8);
        // Render a template
        echo $this->view->render('home', ['photos' => $photos]);
    }
}