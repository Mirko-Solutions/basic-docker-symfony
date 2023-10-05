<?php

namespace App\UserInterface\API\Type\User;

use App\Infrastructure\API\Type\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
class AuthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', EmailType::class, [
            'required' => true,
        ]);

        $builder->add('password', TextType::class, [
            'required' => true,
        ]);
    }
}
