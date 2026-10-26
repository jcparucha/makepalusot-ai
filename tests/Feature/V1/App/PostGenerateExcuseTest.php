<?php

use App\Contracts\Libraries\AiClientInterface;
use Mockery\MockInterface;

use function Pest\Laravel\mock;
use function Pest\Laravel\postJson;

function mockAiClientInterface($timesCalled = 1)
{
    // mock GeminiClient::generateContent
    mock(AiClientInterface::class, function (MockInterface $mock) use ($timesCalled) {
        $mock
            ->expects('generateContent')
            ->times($timesCalled)
            ->andReturn([
                'model' => 'test-model-3',
                'response' => [
                    'candidates' => [
                        [
                            'content' => [
                                'parts' => [
                                    ['text' => 'This is a generated result.', 'thoughSignature' => '123abc456def'],
                                ],
                                'role' => 'model',
                            ],
                        ],
                    ],
                ],
                'errors' => [
                    'test-model-1' => ['Something went wrong.'],
                    'test-model-2' => ['Something went wrong.'],
                ],
            ]);
    });
}

test('returns 422 validation error when payload is required', function () {
    // empty payload
    $response1 = postJson('/api/v1/generate', []);
    $response2 = postJson('/api/v1/generate', ['excuse' => '', 'tone' => '', 'language' => '']);

    $response1->assertUnprocessable();
    $response2->assertUnprocessable();

    $response1->assertJsonValidationErrors(['excuse', 'tone'], 'errors');
    $response2->assertJsonValidationErrors(['excuse', 'tone'], 'errors');
});

test('returns 422 validation error when "excuse" payload has incorrect min and max value', function () {
    $url = '/api/v1/generate';
    $payload = ['excuse' => 'I am not.', 'tone' => 'formal', 'language' => 'english'];

    // should be at least 10 characters
    $response1 = postJson($url, $payload);
    // should be maximum of 250 characters
    $response2 = postJson($url, [...$payload, 'excuse' => fake()->realTextBetween(255, 300)]);

    $response1->assertUnprocessable();
    $response2->assertUnprocessable();

    $response1->assertJsonValidationErrorFor('excuse', 'errors');
    $response2->assertJsonValidationErrors('excuse', 'errors');
});

test('returns 422 validation error when "excuse" payload has invalid special characters', function () {
    $response = postJson('/api/v1/generate', [
        'excuse' => "Am I in the wrong if I want to add ^.^, but this is the only acceptable characters '.,-'()[]/'?",
        'tone' => 'formal',
        'language' => 'english',
    ]);

    $response->assertUnprocessable();

    $response->assertJsonValidationErrorFor('excuse', 'errors');
});

test('returns 422 validation error when "tone" payload has invalid value', function () {
    $response = postJson('/api/v1/generate', [
        'excuse' => 'I want to exercise, but I am too lazy to do it.',
        'tone' => 'lovely',
        'language' => 'english',
    ]);

    $response->assertUnprocessable();

    $response->assertJsonValidationErrorFor('tone', 'errors');
});

test('returns 422 validation error when "language" payload has invalid value', function () {
    $response = postJson('/api/v1/generate', [
        'excuse' => 'I want to exercise, but I am too lazy to do it.',
        'tone' => 'formal',
        'language' => 'japanese',
    ]);

    $response->assertUnprocessable();

    $response->assertJsonValidationErrorFor('language', 'errors');
});

test('returns 200 OK when valid request and successful response', function () {
    mockAiClientInterface();

    $response = postJson('/api/v1/generate', [
        'excuse' => 'I want to exercise, but I am too lazy to do it.',
        'tone' => 'casual',
        'language' => 'english',
    ]);

    $response->assertOk();

    $response->assertJsonStructure(['data' => ['model', 'result', 'errors'], 'version']);
});

test('returns 429 Too Many Request when spammed generate endpoint', function () {
    $maxRequest = 5;
    $url = '/api/v1/generate';
    $payload = [
        'excuse' => 'I want to exercise, but I am too lazy to do it.',
        'tone' => 'casual',
        'language' => 'english',
    ];

    // it will be called n times based on the $maxRequest
    // it will not be called after the loop because of rate limitting
    mockAiClientInterface($maxRequest);

    for ($i = 0; $i < $maxRequest; $i++) {
        $response = postJson($url, $payload);
        $response->assertOk();
    }

    // one more send
    $response = postJson($url, $payload);

    $response->assertTooManyRequests();
    $response->assertJson(['message' => 'Too Many Attempts.']);
});

test('returns 503 Service Unavailable when AI service is unavailable', function () {
    // mock GeminiClient::generateContent
    mock(AiClientInterface::class, function (MockInterface $mock) {
        $mock
            ->expects('generateContent')
            ->once()
            ->andReturn([
                'model' => null,
                'response' => null,
                'errors' => [
                    'test-model-1' => ['Something went wrong.'],
                    'test-model-2' => ['Something went wrong.'],
                    'test-model-3' => ['Something went wrong.'],
                ],
            ]);
    });

    $response = postJson('/api/v1/generate', [
        'excuse' => 'I want to exercise, but I am too lazy to do it.',
        'tone' => 'casual',
        'language' => 'english',
    ]);

    $response->assertServiceUnavailable();

    $response->assertJsonStructure(['message', 'version']);
});
