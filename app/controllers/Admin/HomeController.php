<?php


namespace App\controllers\Admin;


class HomeController extends Controller
{
    public function index()
    {
        echo $this->view->render('Admin/dashboard');
    }

}