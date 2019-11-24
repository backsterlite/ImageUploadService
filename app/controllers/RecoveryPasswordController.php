<?php


namespace App\controllers;


use App\models\Notifications;

class RecoveryPasswordController extends Controller
{
    /**
     * @var Notifications
     */
    private $notifications;

    public function __construct(Notifications $notifications)
    {
        parent::__construct();
        $this->notifications = $notifications;
    }

    public function showForm()
    {
        echo $this->view->render('auth/password-recovery');

    }

    public function recovery()
    {
        try {
            $this->auth->forgotPassword($_POST['email'], function ($selector, $token) {
                $this->notifications->recoveryPassword($_POST['email'],  $selector, $token);

                flash()->success('Код подтверждения смены пароля отправлен на почту');
                return back();
//                echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
           });

        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            flash()->error('Invalid email address');
            return back();
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            flash()->error('Email not verified');
            return back();

        }
        catch (\Delight\Auth\ResetDisabledException $e) {
            flash()->error('Password reset is disabled');
            return back();

        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error('Too many requests');
            return back();
        }
    }

    public function showSetForm()
    {
        try {
            $this->auth->canResetPasswordOrThrow($_GET['selector'], $_GET['token']);

            $data = $_GET;
            echo $this->view->render('auth/password-set', compact('data'));
//            echo 'Put the selector into a "hidden" field (or keep it in the URL)';
//            echo 'Put the token into a "hidden" field (or keep it in the URL)';
//
//            echo 'Ask the user for their new password';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            flash()->error('Invalid token');
            return redirect('/password-recovery');

        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            flash()->error('Token expired');
            return redirect('/password-recovery');
        }
        catch (\Delight\Auth\ResetDisabledException $e) {
            flash()->error('Password reset is disabled');
            return redirect('/password-recovery');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error('Too many requests');
            return redirect('/password-recovery');
        }
    }

    public function change()
    {
        try {
            $this->auth->resetPassword($_POST['selector'], $_POST['token'], $_POST['new-password']);
            flash()->success('Пароль успешно изменен');
            return  redirect('/login');
//            echo 'Password has been reset';
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            flash()->error('Invalid token');
            return  redirect('/login');

        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            flash()->error('Token expired');
            return  redirect('/login');

        }
        catch (\Delight\Auth\ResetDisabledException $e) {
            flash()->error('Password reset is disabled');
            return  redirect('/login');

        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error('Invalid password');
            return  redirect('/login');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error('Too many requests');
            return  redirect('/login');
        }
    }
}