<?php

namespace App\Helpers;


class APIHelper {

    public function responseSuccess($data, $message, $status = 200){
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function responseCreated($message, $status = 201){
        return response()->json([
            'success' => true,
            'message' => $message,
        ], $status);
    }

    public function responseNotFound($message, $status = 404){
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    public function responseError($message, $status = 400){
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }

}
