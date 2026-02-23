<?php

namespace App\Helpers;

use App\Entity\Image;
use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageUploaderInterface
{
    public function parseUploadedFile(UploadedFile $file): Image;

    public function setOwner(User $user): void;

    public function getName(): string;
}
