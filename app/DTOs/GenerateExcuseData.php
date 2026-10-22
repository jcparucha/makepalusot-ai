<?php

namespace App\DTOs;

final class GenerateExcuseData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $excuse,
        public readonly string $tone,
        public readonly string $language,
    ) {}
}
