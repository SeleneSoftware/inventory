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
            'sku',
            'slug',
            AssociationField::new('category'),
            TextareaField::new('description'),
            MoneyField::new('cost')->setCurrency('USD'),
            'qty',
            // ArrayField::new('keywords'),
            CollectionField::new('attributes')
                ->setEntryIsComplex()
                ->useEntryCrudForm(AttributesCrudController::class),
            'public',
        ];
    }
}
