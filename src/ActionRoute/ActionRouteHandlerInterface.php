<?php

namespace AlexTanVer\ActionRouteBundle\ActionRoute;

interface ActionRouteHandlerInterface
{
    public function dispatch(string $action, array $data): mixed;

}
