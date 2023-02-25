<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileService
{
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function uploadFile($file, $destination, $imageName)
    {
        $imagePath = $destination . $imageName;
        if (file_exists($imagePath)) {
            $this->filesystem->remove($imagePath);
        }

        try {
            $file->move($destination, $imageName);
        } catch (FileException $e) {
            return false;
        }

        return true;
    }
}