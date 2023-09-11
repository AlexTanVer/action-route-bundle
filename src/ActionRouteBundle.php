<?php

namespace AlexTanVer\ActionRouteBundle;

use AlexTanVer\ActionRouteBundle\DependencyInjection\Compiler\ControllerCompiler;
use AlexTanVer\ActionRouteBundle\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ActionRouteBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ControllerCompiler());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new Extension();
    }

}
