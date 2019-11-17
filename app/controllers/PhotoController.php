<?php


namespace App\controllers;


use App\models\ImageManager;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class PhotoController extends Controller
{
    /**
     * @var ImageManager
     */
    private $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        parent::__construct();
        $this->imageManager = $imageManager;
    }

    public function create()
    {
        echo $this->view->render('/photos/create');
    }

    public function store()
    {
        $validator = v::key('title', v::stringType()->notEmpty())
            ->key('description', v::stringType()->notEmpty())
            ->key('category_id', v::intVal())
            ->keyNested('image.tmp_name', v::image());

        $this->validate($validator);
        $image = $this->imageManager->uploadImage($_FILES['image']);
        $dimensions = $this->imageManager->getDimensions($image);
       $data = [
           'title'       => $_POST['title'],
           'description' => $_POST['description'],
           'category_id' => $_POST['category_id'],
           'image'       => $image,
           'dimensions'  => $dimensions,
           'user_id'     => $this->auth->getUserId()
       ];
        if($this->database->create($data))
        {
            flash()->success('Картинка загружена');
        }else{
            flash()->error('Произошла ошибка');
        }
        return back();

    }

    public function index()
    {
        $page = isset($_GET['page'])? $_GET['page']: 1;
        $perPage = 8;

        $photos = $this->database->getPaginateFrom('photos', 'user_id', $this->auth->getUserId(), $page, $perPage);
        $paginator = paginate($this->database->getCount('photos', 'user_id', $this->auth->getUserId()),
            $page,
            $perPage,
            "/photos/gallery?page=(:num)");
        echo $this->view->render('photos/gallery', [
            'photos' => $photos,
            'paginator' => $paginator
        ]);
    }

    public function showOne($id)
    {
        $photo     = $this->database->find('photos', $id);
        $user       = $this->database->find('users', $photo['user_id']);
        $userImages = $this->database->whereAll('photos', 'user_id', $photo['user_id'], 4);

        echo $this->view->render('photos/singlePhoto', compact(['photo', 'user', 'userImages']));

    }

    public function download($id)
    {
        $image = $this->database->find('photos', $id);
        echo $this->view->render('photos/download', compact('image'));
    }
    private function validate($validator)
    {
        try {
            $validator->assert(array_merge($_POST, $_FILES));

        } catch (ValidationException $exception) {
            $exception->findMessages($this->getMessages());
            flash()->error($exception->getMessages());

            return back();
        }
    }

    private function getMessages()
    {
        return [
            'title' => 'Введите название',
            'description'   =>  'Введите описание',
            'category_id'   =>  'Выберите категорию',
            'image' =>  'Неверный формат картинки'
        ];
    }
}