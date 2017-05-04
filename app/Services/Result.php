<?php

namespace App\Services;

class Result {


    public static function ok($message = '',$data = []) {
        return [
            'isOk'      => true,
            'message'   => $message
            'data'      =>  $data
        ];
    }

    public static function badRequest($errors = array()) {

        return [
            'isOk'      => false,
            'message'   => $errors
        ];
    }
}