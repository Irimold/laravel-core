<?php

namespace Irimold\LaravelCore\Constants;

class BaseConstant
{
    protected const CSV_FORMAT    = 'csv';
    protected const ARRAY_FORMAT  = 'array';
    protected const JSON_FORMAT   = 'json';

    public const VALUES = [];

    public static function getValues(?string $format)
    {
        switch ($format) {
            case static::CSV_FORMAT:
                return implode(',', static::VALUES);

            case static::JSON_FORMAT:
                return json_encode(static::VALUES);
            
            default:
                return static::VALUES;
        }
    }
}