<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected function sendResponse($data = [], $message = null, $statusCode = 200, $additionalData = [])
    {
        $response = [
            'status' => $statusCode,
            'data' => $data,
            'message' => $message,
        ];

        $response = array_merge($response, $additionalData);

        return response()->json($response, $statusCode);
    }

    protected function sendError($data = [], $message, $statusCode = 201)
    {
        $response = [
            'status' => $statusCode,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }
}
