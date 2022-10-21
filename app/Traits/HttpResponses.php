<?php

namespace App\Traits;

trait HttpResponses{
    //Success Handle
    protected function success($data,$message=null,$code=200){
        return \response()->json([
            'status' => 'Request was successful',
            'message' => $message,
            'data' => $data
        ],$code);
    }

    //Error Handle
    protected function error($data,$message=null,$code){
        return \response()->json([
            'status' => 'Error has occured',
            'message' => $message,
            'data' => $data
        ],$code);
    }
}