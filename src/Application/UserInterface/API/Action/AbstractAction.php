<?php

namespace App\UserInterface\API\Action;

use Twig\Environment;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use App\Infrastructure\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
abstract class AbstractAction implements ServiceSubscriberInterface, ContainerAwareInterface
{
    protected ContainerInterface $container;
    private FormFactoryInterface $formFactory;
    private RequestStack $requestStack;

    public function __construct(FormFactoryInterface $formFactory, RequestStack $requestStack) {

        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

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

    protected function responseCollection(ResponseInterface $response, mixed $data): JsonResponse
    {
        $mergeData = [];
        foreach ($data as $datum) {
            $mergeData[] = $this->renderData($response, $datum);
        }

        $responseData = [
            "type" => 'Collection',
            "data" => $mergeData,
        ];

        if($response->hasMeta()) {
            $responseData['meta'] = $response->getMeta($data);
        }

        return new JsonResponse($responseData);
    }

    protected function response(ResponseInterface $response, mixed $data): JsonResponse
    {
        $responseData = $this->renderData($response, $data);

        return new JsonResponse($responseData);
    }

    protected function handleType(string $formType)
    {
        /** @var RequestStack $request */
        $request = $this->requestStack->getCurrentRequest();
        $form = $this->createForm($formType);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            return $form->getData();
        }
        foreach ($form->getErrors() as $error) {
            // dd($error->getMessage());
        }

    //    throw new BadRequestException();
    }

    private function renderData(ResponseInterface $response, mixed $data): array
    {
        return [
            "type" => $response->getType($data),
            "data" => $response->render($data),
        ];
    }

    /**
     * Creates and returns a Form instance from the type of the form.
     */
    protected function createForm(string $type, mixed $data = null, array $options = []): FormInterface
    {
        return $this->formFactory->create($type, $data, $options);
    }
}
