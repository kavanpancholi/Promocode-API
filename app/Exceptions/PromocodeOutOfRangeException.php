<?php

namespace App\Exceptions;

use Exception;

class PromocodeOutOfRangeException extends Exception
{
    public function render()
    {
        $response = [
            'status' => 'error',
            'message' => "Sorry. Your destination is not in the range.",
        ];
        return response()->json($response, 400);
    }
}
