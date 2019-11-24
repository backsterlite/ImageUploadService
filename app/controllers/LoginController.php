<?php


namespace App\controllers;



class LoginController extends Controller
{
    public  function showForm()
    {
        echo $this->view->render('auth/login' );
    }
    public function login()
    {
        try {
            $rememberDuration = null;
            if(isset($_POST['remember']))
            {
                $rememberDuration =  (int) (60 * 60 * 24 * 30);
            }
            $this->auth->login($_POST['email'], $_POST['password'], $rememberDuration);

            $this->checkIsBanned();
            return redirect('/');
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            flash()->error(['Email не верный']);
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error(['Неверный пароль']);
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            flash()->error(['Email не подтвержден']);
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error(['КУда ломишься?!']);
        }

        return back();
        }
    public function checkIsBanned()
    {
        if($this->auth->isBanned()) {
            flash()->error(['Вы забанены.']);
            $this->auth->logout();
            return redirect('/login');
        }
    }

    public function logout()
    {
        try {
            $this->auth->logOut();
            return redirect('/');
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            return back();
        }
    }

}