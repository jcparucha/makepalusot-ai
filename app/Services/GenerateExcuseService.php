<?php

namespace App\Services;

use App\DTOs\GenerateExcuseData;

class GenerateExcuseService
{
    public function __invoke(GenerateExcuseData $data)
    {
        return 'Generate Excuse';
    }
}
