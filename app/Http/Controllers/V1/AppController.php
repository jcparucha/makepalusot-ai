<?php

namespace App\Http\Controllers\V1;

use App\DTOs\GenerateExcuseData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppRequest;
use App\Services\GenerateExcuseService;

class AppController extends Controller
{
    public function generate(AppRequest $request, GenerateExcuseService $generateExcuse)
    {
        // TODO call AppService::generate
        // create AILibrary
        // create Gemini Util
        $data = new GenerateExcuseData(...$request->all());

        return response()->json([
            'message' => $generateExcuse($data),
            'version' => config('version.number'),
        ]);
    }
}
