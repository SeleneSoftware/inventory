<?php

// src/Form/PermissionType.php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('view', CheckboxType::class, ['required' => false])
            ->add('create', CheckboxType::class, ['required' => false])
            ->add('edit', CheckboxType::class, ['required' => false])
            ->add('delete', CheckboxType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // This ensures the form doesn't complain about not having a class
        $resolver->setDefaults(['data_class' => null]);
    }
}
