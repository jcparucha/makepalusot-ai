<?php

namespace App\Services;

use App\Contracts\Libraries\AiClientInterface;
use App\DTOs\GenerateExcuseData;

class GenerateExcuseService
{
    public function __construct(private AiClientInterface $geminiClient) {}

    public function __invoke(GenerateExcuseData $data)
    {
        $content = $this->geminiClient->generateContent($data);

        $response = $content['response'];
        $errors = $content['errors'];

        // check if empty response and have errors
        if (empty($response) && count($errors) > 0) {
            abort(503, config('lang.errors.gemini')['503'], [
                'Content-Type' => 'application/json',
            ]);
        }

        return [
            'model' => $content['model'],
            'result' => $response['candidates'][0]['content']['parts'][0]['text'],
            'errors' => $errors,
        ];
    }
}
