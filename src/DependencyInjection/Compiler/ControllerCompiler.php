<?php

namespace AlexTanVer\ActionRouteBundle\DependencyInjection\Compiler;

use AlexTanVer\ActionRouteBundle\ActionRoute\ActionRoute;
use AlexTanVer\ActionRouteBundle\ActionRoute\ActionRouteHandler;
use AlexTanVer\ActionRouteBundle\DTO\Request\RequestData;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ControllerCompiler implements CompilerPassInterface
{
    /**
     * @throws ReflectionException
     */
    public function process(ContainerBuilder $container): void
    {
        $actionRouteHandlerDefinition = $container->findDefinition(ActionRouteHandler::class);
        $actionRoutes                 = $container->findTaggedServiceIds('game_action_route');

        foreach ($actionRoutes as $controller => $actions) {
            $controllerReflection = new ReflectionClass($controller);
            foreach ($actions as $action) {
                $method     = $controllerReflection->getMethod($action['method']);
                $attributes = $method->getAttributes(\AlexTanVer\ActionRouteBundle\Configuration\ActionRoute::class);

                $parameters = [];
                foreach ($method->getParameters() as $parameter) {
                    if ($parameter->getType()->getName() === RequestData::class) {
                        $parameters[] = new Definition(RequestData::class);
                    } else {
                        $parameters[] = new Reference($parameter->getType()->getName());
                    }
                }

                foreach ($attributes as $attribute) {
                    $actionRouteHandlerDefinition->addMethodCall('addRoute', [
                        new Definition(
                            ActionRoute::class,
                            [
                                $attribute->getArguments()['action'],
                                new Reference($controller),
                                $action['method'],
                                $parameters,
                            ]
                        ),
                    ]);
                }
            }
        }
    }

}
