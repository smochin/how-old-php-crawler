<?php

declare(strict_types=1);

namespace Smochin\HowOld\Util;

class JSONParser
{
    /**
     * @param string $text
     *
     * @return array
     */
    public static function parse(string $text): array
    {
        $text = substr($text, 1, -1);
        $text = stripcslashes($text);
        $text = stripcslashes($text);
        $text = str_replace('"[', '[', $text);
        $text = str_replace(']"', ']', $text);

        return json_decode($text, true);
    }
}
