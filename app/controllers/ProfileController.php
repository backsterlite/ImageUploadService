<?php


namespace App\controllers;

use App\models\Profile;
class ProfileController extends Controller
{
    /**
     * @var Profile
     */
    private $profile;

    public function __construct(Profile $profile)
    {
        parent::__construct();
        $this->profile = $profile;
    }
    public function showProfileInfo()
    {
        if ($this->auth->isLoggedIn()) {
            $info =  $this->database->find('users', $this->auth->getUserId());
            $image = ($info['image'] != '')? 'uploads/' . $info['image']: 'img/no-user.png';
            echo $this->view->render('profile/info', ['info' => $info, 'image' => $image]);
        }
        else {
            return redirect('/');
        }

    }
    public function showProfileSecurity()
    {
        echo $this->view->render('profile/security');
    }
    public function updateUserInfo()
    {
        $this->profile->changeUserData($_POST['email'], $_FILES['image'], $_POST['username']);
        flash()->success('Профиль успешно обновлен');
        return back();
    }
    public function updateUserSecurity()
    {
        try {
            $this->auth->changePassword($_POST['oldPassword'], $_POST['newPassword']);
            flash()->success('Пароль был изменнен');
            return back();
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            flash()->error('Вы не вошли в систему');
            return back();

        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error('Пароль не верен');
            return back();
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error('Слишком много запросов');
            return back();
        }
    }

}