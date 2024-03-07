<?php

namespace App\Users\Infrastructure\Adapters;

use App\ModuleX\Infrastructure\API\API;

class ModuleXAdapter
{
    public function __construct(private readonly API $moduXApi)
    {
    }

    public function getSomeData(): array
    {
        $this->moduXApi->getSomeData();
        // mapping

        return [];
    }
}