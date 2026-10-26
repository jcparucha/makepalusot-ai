<?php

namespace App\Contracts\Libraries;

use App\DTOs\GenerateExcuseData;

interface AiClientInterface
{
    public function generateContent(GenerateExcuseData $data): array;
}
