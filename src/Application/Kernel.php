<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getProjectDir(): string
    {
        $dir = parent::getProjectDir();

        return $dir . "/src";
    }

    /**
     * Gets the path to the configuration directory.
     */
    private function getConfigDir(): string
    {
        return $this->getProjectDir().'/config';
    }

}
