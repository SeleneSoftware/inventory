<?php

namespace App\Controller\Admin;

use App\Entity\Attributes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AttributesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Attributes::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('value'),
        ];
    }
}
