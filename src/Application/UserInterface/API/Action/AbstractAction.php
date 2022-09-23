<?php

namespace App\UserInterface\API\Action;

use Twig\Environment;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
abstract class AbstractAction implements ServiceSubscriberInterface
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;

    /**
     * @required
     */
    #[Required]
    public function setContainer(ContainerInterface $container): ?ContainerInterface
    {
        $previous = $this->container;
        $this->container = $container;

        return $previous;
    }

    /**
     * Gets a container parameter by its name.
     */
    protected function getParameter(string $name): array|bool|string|int|float|\UnitEnum|null
    {
        if (!$this->container->has('parameter_bag')) {
            throw new ServiceNotFoundException('parameter_bag.', null, null, [], sprintf('The "%s::getParameter()" method is missing a parameter bag to work properly. Did you forget to register your controller as a service subscriber? This can be fixed either by using autoconfiguration or by manually wiring a "parameter_bag" in the service locator passed to the controller.', static::class));
        }

        return $this->container->get('parameter_bag')->get($name);
    }

    public static function getSubscribedServices(): array
    {
        return [
            'router' => '?'.RouterInterface::class,
            'request_stack' => '?'.RequestStack::class,
            'http_kernel' => '?'.HttpKernelInterface::class,
            'serializer' => '?'.SerializerInterface::class,
            'security.authorization_checker' => '?'.AuthorizationCheckerInterface::class,
            'twig' => '?'.Environment::class,
            'form.factory' => '?'.FormFactoryInterface::class,
            'security.token_storage' => '?'.TokenStorageInterface::class,
            'security.csrf.token_manager' => '?'.CsrfTokenManagerInterface::class,
            'parameter_bag' => '?'.ContainerBagInterface::class,
        ];
    }
}
