<?php


namespace App\controllers\Admin;


use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class CategoryController extends Controller
{
    public function index()
    {
        echo $this->view->render('admin/categories/index');
    }

    public function create()
    {
        echo $this->view->render('admin/categories/create');
    }

    public function store()
    {
        $validator = v::key('title', v::stringType()->notEmpty());
        $this->validate($validator, $_POST, ['title' =>  'Введите название поля']);

        $this->database->create('categories', $_POST);

        return redirect('/admin/category');
    }

    public function edit($id)
    {
        $category = $this->database->find('categories', $id);
        echo $this->view->render('Admin/categories/edit', compact('category'));
    }

    public function update($id)
    {
        $validator = v::key('title', v::stringType()->notEmpty());

        $this->validate($validator, $_POST, ['title' =>  'Введите название поля']);

        $this->database->update('categories', $_POST, $id );

        flash()->success(['Запись успешно обновлена']);

        return redirect('/admin/category');
    }
    public function delete($id)
    {
        $this->database->delete('categories', $id);
        flash()->success(['Запись успешно удалена']);

        return redirect('/admin/category');
    }


    private function validate($validator, $data, $message)
    {
        try {
            $validator->assert($data);

        } catch (ValidationException $exception) {
            $exception->findMessages($message);
            flash()->error($exception->getMessages());

            return back();
        }
    }


}