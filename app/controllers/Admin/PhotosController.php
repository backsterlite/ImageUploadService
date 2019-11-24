<?php


namespace App\controllers\Admin;


use App\models\ImageManager;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class PhotosController extends Controller
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

    public function index()
    {
        $photos = $this->database->all('photos');

        echo $this->view->render('Admin/photos/index', compact('photos'));
    }

    public function create()
    {
        echo $this->view->render('admin/photos/create');
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
        return redirect('/admin/photos');
    }

    public function edit($id)
    {
        $photo = $this->database->find('photos', $id);
        echo $this->view->render('Admin/photos/edit', compact('photo'));
    }

    public function update($id)
    {
        $validator = v::key('title', v::stringType()->notEmpty())
            ->key('description', v::stringType()->notEmpty())
            ->key('category_id', v::intVal())
            ->keyNested('image.tmp_name', v::optional(v::image()));

        $this->validate($validator);
        $photo = $this->database->find('photos', $id);

        $image = $this->imageManager->uploadImage($_FILES['image'], $photo['image']);
        $dimensions = $this->imageManager->getDimensions($image);

        $data = [
            "image" =>  $image,
            "title" =>  $_POST['title'],
            "description" =>  $_POST['description'],
            "category_id" =>  $_POST['category_id'],
            "user_id"   =>  $this->auth->getUserId(),
            "dimensions"    =>  $dimensions
        ];
        $this->database->update('photos', $data, $id );

        flash()->success(['Запись успешно обновлена']);

        return redirect('/admin/photos');
    }
    public function delete($id)
    {
        $this->database->delete('photos', $id);
        flash()->success(['Запись успешно удалена']);

        return redirect('/admin/photos');
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