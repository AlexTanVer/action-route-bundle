<?php

namespace AlexTanVer\ActionRouteBundle\DependencyInjection;

use AlexTanVer\ActionRouteBundle\Configuration\ActionRoute;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension as SymfonyExtension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Extension extends SymfonyExtension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container->registerAttributeForAutoconfiguration(
            ActionRoute::class,
            static function (
                ChildDefinition $definition,
                ActionRoute $attribute,
                ReflectionClass|ReflectionMethod $reflector
            ): void {
                $args = [];
                if ($reflector instanceof ReflectionMethod) {
                    $args['method'] = $reflector->getName();
                }
                $definition->addTag('game_action_route', $args);
            }
        );

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }

    public function getAlias(): string
    {
        return 'game_action_route';
    }

}
