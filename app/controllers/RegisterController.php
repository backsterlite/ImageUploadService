<?php


namespace App\controllers;


use App\models\Mail;
use Delight\Auth\Auth;
use League\Plates\Engine;

class RegisterController extends Controller
{

    private $mailer;

    public function __construct(Mail $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }


    public function showForm()
    {
        echo $this->view->render('auth/register');
    }
    public function registration()
    {

        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
                $message = "http://example02/verify_email?selector=" . \urlencode($selector) . '&token=' . \urlencode($token);
                $this->mailer->send($_POST['email'], $message);
                header('Location: /login');
            });


        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }
}