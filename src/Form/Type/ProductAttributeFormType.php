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

class ProductAttributeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /**
         * Install DynamicFormBuilder:.
         *
         *    composer require symfonycasts/dynamic-forms
         */
        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('name', EntityType::class, [
                'class' => ProductAttribute::class,
                'choice_label' => 'name',
                'placeholder' => 'Please Make a Selection',
                'choice_value' => 'name',
            ]
            )
            ->addDependent('value', 'name', function (DependentField $field, ?ProductAttribute $attribute) {
                $field->add(ChoiceType::class, [
                    'placeholder' => null === $attribute ? 'Select an Attribute First' : 'Please Select a Value',
                    'choices' => $attribute ? $attribute->getValue() : [],
                    'choice_label' => function ($attribute): string {
                        return $attribute;
                    },
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
