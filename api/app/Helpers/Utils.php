<?php


namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Utils
{
    static function ResponseJson($response, $message = '', $success = true, $statusCode = 200)
    {
        if ($response instanceof \Exception) {
            return response()->json(['success' => false, 'errors' => [$response->getMessage(), $response->getFile()], 'data' => null], 406);
        }

        if (is_array($response) && array_key_exists('error', $response)) {
            return response()->json(['data' => null, 'message' => $response['error'], 'success' => false], 400);
        }
        return response()->json(['data' => $response, 'message' => $message, 'success' => $success], $statusCode);
    }

    static function ResponseJsonValidation($response)
    {
        $return = array();

        return response()->json(['success' => false, 'errors' => $response->all(), 'data' => null], 406);
    }
}
