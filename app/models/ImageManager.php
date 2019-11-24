<?php


namespace App\models;


use Intervention\Image\ImageManagerStatic as Image;

class ImageManager
{
    private $folder;

    public function __construct()
    {
        $this->folder = config('uploadsFolder');
    }

    public function uploadImage($image, $currentImage = null)
    {
        if(!is_file($image['tmp_name']) && !is_uploaded_file($image['tmp_name'])){return $currentImage;}

        $this->deleteImage($currentImage);
        $fileName = strtolower(str_random(10)) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $image1 = Image::make($image['tmp_name']);
        $image1->save( $this->folder .  $fileName);
        move_uploaded_file($image['tmp_name'],  $this->folder .  $fileName);
        return $fileName;

    }

    private function checkImageExists($path)
    {
        if($path != '' && is_file($this->folder . $path) && file_exists($this->folder . $path))
        {
            return true;
        }
        return false;
    }

    public function deleteImage($path)
    {
        if($this->checkImageExists($path))
        {
            unlink($this->folder . $path);
        }
    }
    public function getDimensions($file)
    {
        if($this->checkImageExists($file)) {
            list($width, $height) = getimagesize($this->folder . $file);
            return $width . "x" . $height;
        }
    }
     public function getImage($image)
     {
        if($this->checkImageExists($image))
        {
            return '/' . $this->folder . $image;
        }
     }

}