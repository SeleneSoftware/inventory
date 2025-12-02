<?php

namespace App\Form;

use App\Entity\ProductAttribute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
            ->add('name', ChoiceType::class, [
                'choice_label' => function (?ProductAttribute $attribute): string {
                    return $attribute ? strtoupper($attribute->getName()) : '';
                },
                'choice_value' => 'id',
            ]
            )
            ->addDependent('value', 'name', function (DependentField $field, ?ProductAttribute $attribute) {
                $field->add(ChoiceType::class, [
                    'placeholder' => null === $meal ? 'Select an Attribute First' : 'Please Select a Value',
                    'choices' => function (?ProductAttribute $attribute): ?array {
                        return $attribute->getValue();
                        // foreach ($a as $attribute->getValue()) {
                        //     yield strtoupper($a);
                        // }
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
