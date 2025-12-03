<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Store;
use App\Form\Type\ProductAttributeFormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('SKU')
            // ->add('qty') // This is for inital product development.  Since the plan is to have multiple locations for a product stock, this will be removed with location and qty in location.  Also, this really shouldn't be here, it should be added with purchase orders.
            ->add('type', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,
                'choices' => [
                    'Single' => Product::TYPE_SINGLE,
                    'Variable' => Product::TYPE_PARENT,
                    'Virtual' => Product::TYPE_VIRTUAL,
                    'Service' => Product::TYPE_SERVICE,
                    'Bundle' => Product::TYPE_BUNDLE,
                ],
            ])
            ->add('store', EntityType::class, [
                'class' => Store::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('attributes', LiveCollectionType::class, [
                'entry_type' => ProductAttributeFormType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            // ->add('attributes', ProductAttributeFormType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
