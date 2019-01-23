<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFile
{

    private $directory;

    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try {
            $file->move($this->getDirectory(), $fileName);
        } catch (FileException $e) {

        }

        return $fileName;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

}