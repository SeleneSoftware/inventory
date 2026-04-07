<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Type\PermissionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

// use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserPermissionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('store', PermissionType::class)
            ->add('category', PermissionType::class)
            ->add('product', PermissionType::class)
            ->add('location', PermissionType::class)
            ->add('role', CheckboxType::class, [
                'label' => 'Administrator Privileges',
                'required' => false,
                'attr' => [
                    'role' => 'switch',
                    'class' => 'form-check-input',
                ],
            ]);
        // Add the transformer to handle the "admin" <-> true conversion
        $builder->get('role')->addModelTransformer(new CallbackTransformer(
            function ($roleAsString) {
                // Transform: Array value to Form value
                // If "admin", the toggle becomes checked (true)
                return 'admin' === $roleAsString;
            },
            function ($roleAsBoolean) {
                // Reverse Transform: Form value back to Array
                // If checked, return "admin", otherwise "user" (or null)
                return $roleAsBoolean ? 'admin' : 'user';
            }
        ));
    }
}
