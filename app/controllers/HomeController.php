<?php


namespace App\controllers;


use App\models\Database;
use Delight\Auth\Auth;
use League\Plates\Engine;

class HomeController extends Controller
{



    public function index()
    {
        $photos = $this->database->all('photos', 8);
        // Render a template
        echo $this->view->render('home', ['photos' => $photos]);
    }

    public function category($id)
    {
       $page = isset($_GET['page'])? $_GET['page']: 1;
       $perPage = 8;
       $photos = $this->database->getPaginateFrom('photos', 'category_id', $id, $page, $perPage);
       $paginator = paginate($this->database->getCount('photos', 'category_id', $id),
                            $page,
                            $perPage,
                            "/category/$id?page=(:num)");
       $category = $this->database->find('categories', $id);

        echo $this->view->render('category_id', [
            'paginator' => $paginator,
            'category'      => $category,
            'photos'     => $photos
        ]);
    }

    public function user($id)
    {
        $page = isset($_GET['page'])? $_GET['page']: 1;
        $perPage = 8;
        $photos = $this->database->getPaginateFrom('photos', 'user_id', $id, $page, $perPage);
        $paginator = paginate($this->database->getCount('photos', 'user_id', $id),
            $page,
            $perPage,
            "/user/$id?page=(:num)");
        $user = $this->database->find('users', $id);


        echo $this->view->render('user', [
            'paginator' => $paginator,
            'photos'     => $photos,
            'user'      => $user
        ]);
    }
}