<?php

namespace AlexTanVer\ActionRouteBundle\ActionRoute;

class ActionRoute
{
    private string $action;

    private object $controller;

    private string $method;

    private array $methodParameters;

    public function __construct(
        string $action,
        object $controller,
        string $method,
        array $methodParameters = []
    ) {
        $this->action           = $action;
        $this->controller       = $controller;
        $this->method           = $method;
        $this->methodParameters = $methodParameters;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getController(): object
    {
        return $this->controller;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getMethodParameters(): array
    {
        return $this->methodParameters;
    }

}
