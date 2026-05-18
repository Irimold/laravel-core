<?php

if (!function_exists('array_response')) {
    /**
     * Array response for logics & services
     * 
     * @return array{
     *  message : string,
     *  data    : mixed,
     *  success : bool,
     *  code    : int
     * }
     */
    function array_response(?string $message    = '', 
                            mixed   $data       = null, 
                            ?bool   $success    = true,
                            ?int    $code       = 200) : array
    {
        return [
            'message'   => $message,
            'data'      => $data,
            'success'   => $success,
            'code'      => $code,
        ];
    }
}

if (!function_exists('success')) {
    /**
     * Array success response for logics & services
     */
    function success(?string $message = 'Success', mixed $data = null)
    {
        return array_response($message, $data);
    }
}

if (!function_exists('failed')) {
    /**
     * Array failed response for logics & services
     */
    function failed(?string $message = 'An error occured!', mixed $data = null, ?int $code = 500)
    {
        return array_response($message, $data, false, $code);
    }
}
