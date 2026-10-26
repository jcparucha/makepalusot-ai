<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof Response) {
            // only manipulate response data if it is application/json
            if ($response->headers->get('Content-Type') === 'application/json') {
                $custom = [];
                $content = json_decode($response->getContent(), true);

                if ($response->getStatusCode() === 200) {
                    $custom['data'] = $content;
                } else {
                    $custom = $content;
                }

                $custom['version'] = config('version.number');
                $response->setContent(json_encode($custom));
            }
        }

        return $response;
    }
}
