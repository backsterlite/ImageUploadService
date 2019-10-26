<?php


namespace App\controllers;



class LoginController extends Controller
{
    public  function showForm()
    {
        echo $this->view->render('auth/login' );
    }
}