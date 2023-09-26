<?php

namespace App\UserInterface\API\Type\User;

use App\Infrastructure\API\Type\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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

        $builder->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => true,
            'first_options'  => ['label' => 'Password'],
            'second_options' => ['label' => 'Repeat Password'],
            'constraints' => [
                new NotNull()
            ]
        ]);
    }
}
