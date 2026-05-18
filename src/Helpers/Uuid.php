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


    private static function getTimeHexes()
    {
        $time   = time();
        $binary = base_convert($time, 10, 2);
        $binary = static::trimBinary($binary, static::MAX_TIME_BITS);

        $hex = static::binaryToHex($binary, static::MAX_TIME_BITS);
        return str_split($hex, 8);
    }

    private static function getCounterHexes(int $counter)
    {
        $binary = base_convert($counter, 10, 2);
        $binary = static::trimBinary($binary, static::MAX_COUNTER_BITS);

        $hex = static::binaryToHex($binary, static::MAX_COUNTER_BITS);
        return str_split($hex, 3);
    }

    private static function getRandomHex()
    {
        $byteSize   = ceil((float)static::MAX_RANDOM_BITS / 8.0);
        $random     = random_bytes($byteSize);
        $hex        = bin2hex($random);

        $binary = base_convert($hex, 16, 2);
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
        $hex = base_convert($binary, 2, 16);
        return str_pad($hex, $length, '0', STR_PAD_LEFT);
    }
}