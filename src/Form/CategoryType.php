<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Store;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfonycasts\DynamicForms\DependentField;
use Doctrine\ORM\EntityRepository;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('name')
            ->add('store', EntityType::class, [
                'class' => Store::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose One',
            ])
            ->addDependent('parent', 'store', function (dependentField $field, ?Store $store) {
                $field->add(EntityType::class, [
                    'class' => Category::class,
                    'query_builder' => function (EntityRepository $er) use ($store) {
                        return $er->createQueryBuilder('c')
                                  ->where('c.store = :store')
                                  ->setParameter('store', $store);
                    },
                    'choice_label' => 'name',
                    'placeholder' => 'Choose One',
                    'required'=>false,
                ])
                ;

            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
