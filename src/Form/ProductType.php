<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\Type\ProductAttributeFormType;
use App\Form\Type\VariantAttributesType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);
        $builder
            ->add('name')
            // ->add('SKU')
            ->add('type', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Select Product Type',
                'choices' => [
                    'Single' => Product::TYPE_SINGLE,
                    'Variable' => Product::TYPE_PARENT,
                    // these are to remain commented until the logic for them comences.
                    // 'Virtual' => Product::TYPE_VIRTUAL,
                    // 'Service' => Product::TYPE_SERVICE,
                    // 'Bundle' => Product::TYPE_BUNDLE,
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->addDependent('attributes', 'type', function (DependentField $field, ?int $product) {
                if (Product::TYPE_SINGLE !== $product) {
                    return;
                }

                $field->add(LiveCollectionType::class, [
                    'entry_type' => ProductAttributeFormType::class,
                    'entry_options' => ['label' => false],
                    'label' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]);
            })
            ->addDependent('variantsAttr', 'type', function (?DependentField $field, ?int $product) {
                if (Product::TYPE_PARENT !== $product) {
                    return;
                }
                $field->add(LiveCollectionType::class, [
                    'entry_type' => VariantAttributesType::class,
                    'entry_options' => ['label' => false],
                    'label' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'mapped' => false,
                ]);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
