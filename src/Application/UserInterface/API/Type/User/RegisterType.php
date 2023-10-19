<?php

namespace App\UserInterface\API\Type\User;

use App\Domain\DTO\User\UserDTO;
use App\Infrastructure\API\Type\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->getUserFields($builder);
        $builder->add('isAccepted',CheckboxType::class, [
            'required' => true,
            'false_values' => [null,'', '0', 'false'],
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserDTO::class,
        ]);
    }
}
