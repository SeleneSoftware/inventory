<?php

namespace App\Twig\Components;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;

#[AsLiveComponent]
final class ImageModal extends AbstractController
{
    use DefaultActionTrait;
    // use LiveCollectionTrait;

    public array $imageList = [];

    #[LiveProp]
    public ?string $imagePath = '';

    #[LiveProp]
    public ?string $imageAlt = '';

    #[LiveProp]
    public ?string $imageName = '';

    #[LiveProp]
    public string $showModal = 'false';

    public function __construct(
        private ImageRepository $imageRepository,
    ) {
    }

    #[LiveAction]
    public function openImage(#[LiveArg] string $slug): void
    {
        $image = $this->imageRepository->findOneBy(['slug' => $slug]);
        if (!$image) {
            $this->showModal = 'false';

            return;
        }
        $this->imagePath = $image->getUrl();
        $this->imageList = $this->imageRepository->findAll();
        $this->showModal = 'true';
        $this->imageName = $image->getName();
        $this->imageAlt = $image->getAlt();
    }

    #[LiveAction]
    public function closeModal(): void
    {
        $this->imageList = $this->imageRepository->findAll();
        $this->showModal = false;
    }
}
