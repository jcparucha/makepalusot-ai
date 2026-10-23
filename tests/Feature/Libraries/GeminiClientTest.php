<?php

use App\DTOs\GenerateExcuseData;
use App\Libraries\Ai\GeminiClient;
use Illuminate\Support\Facades\Http;

// Follow the testing guide in HTTP
// https://laravel.com/framework/docs/11.x/http-client#testing
describe('GeminiClient::generateContent', function () {
    test('should work properly', function () {
        $gemini = new GeminiClient;
        $data = new GenerateExcuseData(
            excuse: 'I do not want to go to work. Tinatamad ako ngayong araw!',
            tone: 'friendly',
            language: 'taglish',
        );

        Http::fake(['generativelanguage.googleapis.com/*' => ['foo' => 'bar']]);

        $response = $gemini->generateContent($data);

        expect($response)
            ->toBeArray()
            ->toHaveKeys(['model', 'response', 'errors']);
    });

    test('should quietly handle errors', function () {
        $gemini = new GeminiClient;
        $data = new GenerateExcuseData(
            excuse: 'I do not want to go to work. Tinatamad ako ngayong araw!',
            tone: 'friendly',
            language: 'taglish',
        );
        $error429 = [
            'error' => [
                'code' => 429,
                'message' => 'You exceeded your current quota.',
            ],
        ];
        $error503 = [
            'error' => [
                'code' => 503,
                'message' => 'This model is currently experiencing high demand.',
            ],
        ];

        // Test >=400 error code
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response($error429, $error429['error']['code']),
        ]);

        $response1 = $gemini->generateContent($data);

        expect($response1)
            ->toBeArray()
            ->toHaveKeys(['model', 'response', 'errors']);

        // use AI config models count
        // we retry the request to all models, so use the config for assertion
        expect(count($response1['errors']))->toBe(count(config('ai.gemini.models')));

        // Test >=500 error code
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response($error503, $error503['error']['code']),
        ]);

        $response2 = $gemini->generateContent($data);

        expect($response2)
            ->toBeArray()
            ->toHaveKeys(['model', 'response', 'errors']);

        // use AI config models count
        // we retry the request to all models, so use the config for assertion
        expect(count($response2['errors']))->toBe(count(config('ai.gemini.models')));
    });
});
