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
            [
                'name' => 'Products',
                'path' => 'app_products',
            ],
            [
                'name' => 'Product Attributes',
                'path' => 'app_products_attributes',
            ],
            [
                'name' => 'Stock Locations',
                'path' => 'app_stores',
            ],
            [
                'name' => 'Suppliers',
                'path' => 'app_stores',
            ],
        ];
    }
}
