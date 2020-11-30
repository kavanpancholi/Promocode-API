<?php

namespace App\Exceptions;

use Exception;

class GoogleMapDirectionAPIException extends Exception
{
    public function render()
    {
        $response = [
            'status' => 'error',
            'message' => "Error while fetching polylines. Please check Google Map Configurations",
        ];
        return response()->json($response, 500);
    }
}
