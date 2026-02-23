<?php

namespace App\Form\Type;

use App\Entity\ProductAttribute;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class VariantAttributesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /**
         * Install DynamicFormBuilder:.
         *
         *    composer require symfonycasts/dynamic-forms
         */
        $builder = new DynamicFormBuilder($builder);

        $builder->add('variant', EntityType::class, [
            'class' => ProductAttribute::class,
            'choice_label' => 'name',
            'placeholder' => 'Please Make a Selection',
            'choice_value' => 'name',
            'attr' => [
                'class' => 'block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring',
            ],
        ]
        )
        ->addDependent('values', 'variant', function (DependentField $field, ?ProductAttribute $attribute) {
            $field->add(ChoiceType::class, [
                'placeholder' => null === $attribute ? 'Select an Attribute First' : 'Please Select a Value',
                'choices' => $attribute ? $attribute->getValue() : [],
                'choice_label' => function ($attribute): string {
                    return $attribute;
                },
                'attr' => [
                    // 'class' => 'block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring',
                    // 'class' => 'w-4 h-4 text-blue-500 border-gray-300 rounded focus:ring-blue-400',
                ],
                'expanded' => true,
                'multiple' => true,
            ]);
        })
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
