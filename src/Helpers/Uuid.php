<?php

namespace Irimold\LaravelCore\Helpers;

class Uuid
{
    /** Maximum bits */
    const MAX_TIME_BITS     = 36;
    const MAX_COUNTER_BITS  = 24;
    const MAX_RANDOM_BITS   = 62;

    /** UUID Version */
    const VERSION = '8';

    /** UUID Variant (0b10) */
    const VARIANT = '10';

    /**
     * Generate Irimold custom UUID
     */
    public static function generate(int $counter)
    {
        $timeHexes      = static::getTimeHexes();
        $counterHexes   = static::getCounterHexes($counter);
        $randomHex      = static::getRandomHex();

        $segments = [
            $timeHexes[0],
            $timeHexes[1] . $counterHexes[0],
            static::VERSION . $counterHexes[1],
            substr($randomHex, 0, 4),
            substr($randomHex, 4),
        ];

        return implode('-', $segments);
    }

    /**
     * Convert UUID to Base54 encoded UUID string
     */
    public static function encodeBase54(string $uuid)
    {
        $uuid = str_replace('-', '', $uuid);
        return static::baseConvert($uuid, 16, 54);
    }

    /**
     * Convert Base54 encoded UUID string to UUID
     */
    public static function decodeBase54(string $encoded)
    {
        $converted = static::baseConvert($encoded, 54, 16);
        $converted = str_pad($converted, 32, '0', STR_PAD_LEFT);

        $segments = [
            substr($converted, 0, 8),
            substr($converted, 8, 4),
            substr($converted, 12, 4),
            substr($converted, 16, 4),
            substr($converted, 20),
        ];
        
        return implode('-', $segments);
    }


    // Private functions

    private static function getTimeHexes()
    {
        $time   = time();
        $binary = static::baseConvert($time, 10, 2);
        $binary = static::trimBinary($binary, static::MAX_TIME_BITS);

        $hex = static::binaryToHex($binary, static::MAX_TIME_BITS);
        return str_split($hex, 8);
    }

    private static function getCounterHexes(int $counter)
    {
        $binary = static::baseConvert($counter, 10, 2);
        $binary = static::trimBinary($binary, static::MAX_COUNTER_BITS);

        $hex = static::binaryToHex($binary, static::MAX_COUNTER_BITS);
        return str_split($hex, 3);
    }

    private static function getRandomHex()
    {
        $byteSize   = ceil((float)static::MAX_RANDOM_BITS / 8.0);
        $random     = random_bytes($byteSize);
        $hex        = bin2hex($random);

        $binary = static::baseConvert($hex, 16, 2);
        $binary = static::trimBinary($binary, static::MAX_RANDOM_BITS);
        $binary = static::VARIANT . $binary;

        $hex = static::binaryToHex($binary, static::MAX_RANDOM_BITS);
        return $hex;
    }

    private static function trimBinary(string $binary, int $maxLength)
    {
        $length = strlen($binary);
        if ($length > $maxLength) {
            return substr($binary, $length - $maxLength, $maxLength);
        }

        return $binary;
    }

    private static function binaryToHex(string $binary, int $bits)
    {
        $length = ceil((float)$bits / 4);
        $hex = static::baseConvert($binary, 2, 16);
        return str_pad($hex, $length, '0', STR_PAD_LEFT);
    }

    private static function baseConvert(string $number, int $fromBase, int $toBase)
    {
        return gmp_strval(gmp_init($number, $fromBase), $toBase);
    }
}