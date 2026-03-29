<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            // ->add('roles')
            // ->add('permissions', ChoiceType::class, [
            //     'mapped' => false,
            //     'choices' => Role::DEFAULT_ROLES,
            //     'expanded' => true,
            //     'multiple' => true,
            // ])
        ;

        foreach (Role::DEFAULT_ROLES as $entity => $permissions) {
            if (!is_array($permissions)) {
                continue;
            }

            $builder->add($entity, ChoiceType::class, [
                'choices' => array_combine(
                    array_map('ucfirst', array_keys($permissions)),
                    array_keys($permissions)
                ),
                'expanded' => true,
                'multiple' => true,
                'label' => ucfirst($entity),
                'mapped' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
