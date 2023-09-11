<?php

namespace AlexTanVer\ActionRouteBundle\Configuration;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class ActionRoute
{
    private string $action;

    public function __construct(string $action)
    {
        $this->action = $action;
    }

}
