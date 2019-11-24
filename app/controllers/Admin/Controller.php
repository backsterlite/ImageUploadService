<?php


namespace App\controllers\Admin;

use App\controllers\Controller as MainController;
use App\models\Roles;

class Controller extends MainController
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->auth->hasRole(Roles::ADMIN))
        {
            abort(404);
        }
    }
}