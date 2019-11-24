<?php


namespace App\models;


use App\models\Database;
use App\models\Notifications;
use App\models\Roles;
use Delight\Auth\Auth;

class RegisterModel
{
    private $auth;
    private $database;
    private $notifications;

    public function __construct(Auth $auth, Database $database, Notifications $notifications)
    {
        $this->auth = $auth;
        $this->database = $database;
        $this->notifications = $notifications;
    }

    public function make($email, $password, $username)
    {
        $userId = $this->auth->register($email, $password, $username, function ($selector, $token) use($email) {
            // send `$selector` and `$token` to the user (e.g. via email)
            $this->notifications->emailWasChange($email, $selector, $token);
        });

        $this->database->update('users', ['roles_mask' =>  Roles::USER], $userId);

        return $userId;
    }

    public function verify($selector, $token)
    {
        return $this->auth->confirmEmail($selector, $token);
    }

}