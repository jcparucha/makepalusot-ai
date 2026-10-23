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

    public function all(): array
    {
        return [
            'excuse' => $this->excuse,
            'tone' => $this->tone,
            'language' => $this->language,
        ];
    }
}
