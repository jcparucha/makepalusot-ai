<?php

use function Pest\Laravel\get;

test('should render App view', function () {
    $response = get('/');

    $response->assertOk();
    $response->assertViewIs('app');
    // title
    $response->assertSee('<title>MakePalusot-AI</title>', false);
    // vite assets
    $response->assertSee('resources/js/app.ts', false);
    $response->assertSee('resources/css/app.css', false);
});
