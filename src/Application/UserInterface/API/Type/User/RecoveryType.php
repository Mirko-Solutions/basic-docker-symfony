<?php

namespace App\UserInterface\API\Type\User;

use App\Infrastructure\API\Type\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class RecoveryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', EmailType::class, [
            'required' => true,
            'constraints' => [
                new NotNull()
            ]
        ]);
    }
}
