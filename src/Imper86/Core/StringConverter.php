<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 24.08.17
 * Time: 11:59
 */

namespace Imper86\Core;


class StringConverter
{
    public function removePolishCharacters(string $str): string
    {
        $arr = Array(
            //WIN
            "\xb9" => "a", "\xa5" => "A", "\xe6" => "c", "\xc6" => "C",
            "\xea" => "e", "\xca" => "E", "\xb3" => "l", "\xa3" => "L",
            "\xf3" => "o", "\xd3" => "O", "\x9c" => "s", "\x8c" => "S",
            "\x9f" => "z", "\xaf" => "Z", "\xbf" => "z", "\xac" => "Z",
            "\xf1" => "n", "\xd1" => "N",
            //UTF
            "\xc4\x85" => "a", "\xc4\x84" => "A", "\xc4\x87" => "c", "\xc4\x86" => "C",
            "\xc4\x99" => "e", "\xc4\x98" => "E", "\xc5\x82" => "l", "\xc5\x81" => "L",
            "\xc3\xb3" => "o", "\xc3\x93" => "O", "\xc5\x9b" => "s", "\xc5\x9a" => "S",
            "\xc5\xbc" => "z", "\xc5\xbb" => "Z", "\xc5\xba" => "z", "\xc5\xb9" => "Z",
            "\xc5\x84" => "n", "\xc5\x83" => "N",
            //ISO
            "\xb1" => "a", "\xa1" => "A", "\xb6" => "s", "\xa6" => "S",
            "\xbc" => "z",
        );

        return strtr($str, $arr);
    }
}