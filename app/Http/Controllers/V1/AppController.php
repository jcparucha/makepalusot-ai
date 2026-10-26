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
        return response()->json($generateExcuse(new GenerateExcuseData(...$request->all())));
    }
}
