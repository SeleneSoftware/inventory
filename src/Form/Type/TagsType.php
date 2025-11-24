<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TagsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Transform array <-> comma-separated text
        $builder->addModelTransformer(new CallbackTransformer(
            function ($tagsArray) {
                return is_array($tagsArray) ? implode(',', $tagsArray) : '';
            },
            function ($string) {
                if (!$string) {
                    return [];
                }

                return array_filter(array_map('trim', explode(',', $string)));
            }
        ));
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}
