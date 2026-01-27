<?php

namespace App\Helpers;

use App\Entity\Image;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUploader implements ImageUploaderInterface
{
    public function __construct(
        private SluggerInterface $slugger,
        private Filesystem $filesystem,
        private string $targetDirectory = 'upload/images',
    ) {
    }

    public function parseUploadedFile(UploadedFile $file): Image
    {
        $image = new Image();
        try {
            if (!$this->filesystem->exists($this->getTargetDirectory())) {
                $this->filesystem->mkdir($this->getTargetDirectory(), 0775);
            }
        } catch (IOExceptionInterface $exception) {
            throw new \RuntimeException(sprintf('An error occurred while creating your directory at %s', $exception->getPath()));
        }

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        $mime = $file->getMimeType();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
            $image->setPath($this->getTargetDirectory())
                  ->setName($safeFilename)
                  ->setAlt($safeFilename)
                  ->setFilename($fileName)
                  ->setMime($mime)
            ;
        } catch (FileException $e) {
            throw new \Exception(sprintf('An error occurred while saving file: %s', $e->getMessage()));
        }

        return $image;
    }

    public function getTargetDirectory(): string
    {
        // dd(getcwd());

        return getcwd().'/'.$this->targetDirectory;
        // $publicDir = $this->getParameter('kernel.project_dir').'/public';

        // return $publicDir.'/'.$this->targetDirectory;
    }
}
