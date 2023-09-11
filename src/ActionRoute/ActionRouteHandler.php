<?php

namespace AlexTanVer\ActionRouteBundle\ActionRoute;

use AlexTanVer\ActionRouteBundle\DTO\Request\RequestData;

class ActionRouteHandler implements ActionRouteHandlerInterface
{
    private array $routes;

    public function addRoute(ActionRoute $actionRoute): void
    {
        $this->routes[$actionRoute->getAction()] = $actionRoute;
    }

    public function dispatch(string $action, array $data): mixed
    {
        if (isset($this->routes[$action])) {
            $controller       = $this->routes[$action]->getController();
            $method           = $this->routes[$action]->getMethod();
            $methodParameters = $this->routes[$action]->getMethodParameters();

            if (!empty($methodParameters)) {
                foreach ($methodParameters as $methodParameter) {
                    if ($methodParameter instanceof RequestData) {
                        $methodParameter->set($data);
                        break;
                    }
                }
            }

            return $controller->$method(...$methodParameters);
        }

        return null;
    }

}
