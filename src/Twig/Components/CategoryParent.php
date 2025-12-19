<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use App\Entity\Category;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
final class CategoryParent
{
    public Category $category;

    public array $path = [];

    #[PreMount]
    public function preMount(array $data): array
    {
        if (null === $data['category']->getParent()) {
            return [];
        }

        $current = $data['category']->getParent();

        while($current !== null) {
            $names[] = $current->getName();
            $current = $current->getParent();
        }

        $this->path = array_reverse($names);

        return [];
    }

}
