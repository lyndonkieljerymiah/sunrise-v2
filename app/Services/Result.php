<?php

namespace App\Services;

class Result {


    public static function ok($message = '') {
        return [
            'isOk'      => true,
            'message'   => $message
        ];
    }

    public static function badRequest($errors = array()) {

        return [
            'isOk'      => false,
            'message'   => $errors
        ];
    }
}