<?php

namespace Api\Response;

class Response
{
    public static function output($code, $message = null, $payload = null)
    {
        $msg = $message ?? $code['msg'];
        $code = is_array($code) ? $code['code'] : $code;

        header("HTTP/1.1 {$code} {$msg}");

        $response['code'] = $code;
        $response['msg'] = $msg;
        if ($payload)
            $response['payload'] = $payload;

        echo json_encode($response);
    }
}