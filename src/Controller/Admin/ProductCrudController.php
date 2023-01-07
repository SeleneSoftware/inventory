<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'name',
            AssociationField::new('category'),
            TextareaField::new('description'),
            'slug',
            'sku',
            MoneyField::new('price')->setCurrency('USD'),
            'price',
            'qty',
            ArrayField::new('keywords'),
            CollectionField::new('attribute'), // ->useEntryCrudForm(CategoryCrudController::class),
            'public',
        ];
    }
}
