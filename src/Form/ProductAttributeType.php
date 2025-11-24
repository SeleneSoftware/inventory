<?php

namespace App\Form;

use App\Entity\ProductAttribute;
use App\Form\Type\TagsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductAttributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('value', TagsType::class, [
                'required' => false,
                'label' => 'Value',
                'attr' => [
                    'x-data' => 'tagInput()',
                    'x-model' => 'input',
                    'class' => 'hidden', // we hide the underlying text input
                ],
            ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductAttribute::class,
        ]);
    }
}
