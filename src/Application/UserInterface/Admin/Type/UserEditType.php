<?php

namespace App\UserInterface\Admin\Type;

use App\Infrastructure\API\Type\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserEditType extends AbstractType
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

        $builder->add('password', PasswordType::class, [
            'required' => true,
            'constraints' => [
                new NotNull()
            ]
        ]);
    }
}
