<?php

namespace App\Infrastructure\API\Type;

use Symfony\Component\Form\AbstractType as AbstractTypeSymfony;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
abstract class AbstractType extends AbstractTypeSymfony
{
    public function getBlockPrefix()
    {
        return null;
    }
}
