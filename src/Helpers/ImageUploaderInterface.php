<?php

namespace App\Helpers;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageUploaderInterface
{
    public function parseUploadedFile(UploadedFile $file): Image;
}
