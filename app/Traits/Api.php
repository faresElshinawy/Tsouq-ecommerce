<?php

namespace App\Traits;

trait Api {

    public function apiResponse($message = null,$data = null,$errors = null,$code = 200)
    {
        $response = [];

        $response['message'] = $message;

        if($data)
        {
            $response['data'] = $data;
        }

        if($errors)
        {
            $response['errors'] = $errors;
        }

        $response['code'] = $code;

        return response()->json($response);

    }

}
