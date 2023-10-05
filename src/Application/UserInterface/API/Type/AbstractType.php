<?php

namespace App\Infrastructure\API\Type;

use Symfony\Component\Form\AbstractType as AbstractTypeSymfony;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
abstract class AbstractType extends AbstractTypeSymfony
{
    public function getBlockPrefix(): string
    {
        return '';
    }

    public function getUserFields(FormBuilderInterface $builder): FormBuilderInterface
    {
        $builder->add('first_name', TextType::class, [
            'required' => true,
            'constraints' => [
                new NotNull()
            ]
        ]);

        $builder->add('last_name', TextType::class, [
            'required' => true,
            'constraints' => [
                new NotNull()
            ]
        ]);

        $builder->add('email', EmailType::class, [
            'required' => true,
            'constraints' => [
                new NotNull()
            ]
        ]);
        return $builder;
    }
}
