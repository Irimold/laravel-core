<?php

namespace Irimold\LaravelCore\Helpers;

use Illuminate\Http\Request;

class ManualCors
{
    public static function appendHeader(Request $request)
    {
        $origin     = $request->header('origin');
        $support    = config('cors.supports_credentials') ? 'true' : 'false';
        $userAgent  = $request->header('user-agent');

        $isPostman = str_starts_with($userAgent, 'PostmanRuntime/');

        if (!in_array($origin, config('cors.allowed_origins')) &&
            !$isPostman
        ) {
            return false;
        }

        header("Access-Control-Allow-Credentials: {$support}");
        if(!$isPostman) {
            header("Access-Control-Allow-Origin: {$origin}");
        }

        return true;
    }
}
