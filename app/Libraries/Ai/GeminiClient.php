<?php

namespace App\Libraries\Ai;

use App\DTOs\GenerateExcuseData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GeminiClient
{
    public function generateContent(GenerateExcuseData $data): array
    {
        $geminiConfig = config('ai.gemini');

        $response = null;
        $responseError = [];
        $successModel = null;
        $url = $geminiConfig['url'];

        foreach ($geminiConfig['models'] as $model) {
            // TODO [Enhancement]: Move loggings to event listeners?
            // HTTP fire an event: https://laravel.com/framework/docs/11.x/http-client#events
            Log::debug("PREPARING model:{$model}");

            try {
                $updatedUrl = Str::replace(':model', $model, $url);

                // do not throw Illuminate\Http\Client\RequestException
                // manually handle if all retries failed
                $response = Http::retry(3, 100, throw: false)
                    ->withHeaders(['x-goog-api-key' => $geminiConfig['api_key'], 'Content-Type' => 'application/json'])
                    ->post($updatedUrl, [
                        'system_instruction' => [
                            'parts' => [
                                'text' => implode([
                                    'You are an Excuse generator.',
                                    'You will generate an excuse based on',
                                    "{$data->tone} setting",
                                    "and should be in {$data->language}",
                                    'You will generate the result into a single for easier extraction.',
                                ]),
                            ],
                        ],
                        'contents' => [
                            'parts' => [
                                'text' => "User excuse: {$data->excuse}",
                            ],
                        ],
                    ]);

                // dd($response->serverError());

                // catch >= 400 error, log message, and continue to the next model
                if ($response->failed()) {
                    // dd($response['error']['code'], $response->serverError(), $response->failed());
                    // dd($response['error']['code']);
                    $httpCode = $response['error']['code'] ?? 'N/A';
                    $errorMessage = $response['error']['message'] ?? 'It seems that something went wrong.';
                    $context = $response->json() ?? [
                        'url' => $url,
                        'payload' => $data->all(),
                    ];

                    $finalMessage = "FAILED model:{$model}: "."HTTP CODE ($httpCode) - ".$errorMessage;
                    $responseError[$model][] = $finalMessage;

                    Log::debug($finalMessage, $context);

                    continue;
                }

                if ($response->successful()) {
                    $successModel = $model;

                    Log::debug("SUCCESS model:{$model}: Successfully generated a response.", $response->json());

                    break;
                }
            } catch (\Exception $err) {
                // catch Connection Exception like cURL error
                $class = get_class($err);
                Log::error("ERROR ($class) - {$model} failed: ".$err->getMessage());
                $responseError[$model][] = $err->getMessage();
            }
        }

        return [
            'model' => $successModel,
            'response' => ! is_null($response) ? $response->json() : [],
            'errors' => $responseError,
        ];
    }
}
