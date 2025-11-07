<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Sidebar
{
    public string $message;

    public function linksArray(): array
    {
        // Someday, this will be set in the site settings page.
        // But we are still in development, so nope.
        // Manually built array.
        return [
            [
                'name' => 'Stores',
                'path' => 'app_stores',
            ],
        ];
    }
}
