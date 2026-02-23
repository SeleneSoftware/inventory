<?php

namespace App\Helpers;

use App\Entity\Image;
use App\Entity\User;
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

    public function setOwner(User $user): void
    {
        $this->user = $user;
    }

    public function getName(): string
    {
        return 'Filesystem Uploader';
    }

    public function parseUploadedFile(UploadedFile $file, ?string $alt = null): Image
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
                  ->setAlt($alt ?: $safeFilename)
                  ->setFilename($fileName)
                  ->setMime($mime)
                  ->setSlug($safeFilename)
                  ->setUrl($this->targetDirectory.'/'.$fileName)
                  ->setDateUploaded(new \DateTimeImmutable())
                  ->setLastUpdated(new \DateTime())
                  ->setUploadedBy($this->user)
                  // ->setFileSize($file->getSize())
            ;
        } catch (FileException $e) {
            throw new \Exception(sprintf('An error occurred while saving file: %s', $e->getMessage()));
        }

        return $image;
    }

    public function getTargetDirectory(): string
    {
        return getcwd().'/'.$this->targetDirectory;
    }
}
