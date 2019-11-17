<?php


namespace App\models;


use Delight\Auth\Auth;

class Profile
{

    private $database;
    private $auth;
    private $notifications;
    private $imageManager;

    public function __construct(Database $database, Auth $auth, Notifications $notifications, ImageManager $imageManager)
    {

        $this->database = $database;
        $this->auth = $auth;
        $this->notifications = $notifications;
        $this->imageManager = $imageManager;
    }

    public function changeUserData($newEmail,   $image, $newUserName = null)
    {
        if($this->auth->getEmail() != $newEmail)
        {
            try {
                $this->auth->changeEmail($newEmail, function ($selector, $token) use ($newEmail) {
                    $this->notifications->emailWasChange($newEmail, $selector, $token);
                    flash()->success(['На вашу почту' . $newEmail . 'отправлено письмо с кодом подтверждения']);

                });
            }
            catch (\Delight\Auth\InvalidEmailException $e) {
                flash()->error('Некоректный Email');

            }
            catch (\Delight\Auth\UserAlreadyExistsException $e) {
                flash()->error('Такой Email уже существует');

            }
            catch (\Delight\Auth\EmailNotVerifiedException $e) {
                flash()->error('Аккаунт не верифецирован');

            }
            catch (\Delight\Auth\NotLoggedInException $e) {
                flash()->error('Вы не вошли в систему');
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
                flash()->error('Слишком много запросов');
            }

        }

        $user = $this->database->find('users', $this->auth->getUserId());
        $image = $this->imageManager->uploadImage($image, $user['image']);
        $this->database->update('users', [
            'username' =>  isset($newUserName) ? $newUserName : $this->auth->getUsername(),
            'image' => $image
        ], $this->auth->getUserId());
    }
}