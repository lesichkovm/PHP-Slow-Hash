<?php

/*
Copyright (c) 2015 Milan Lesichkov
Website: http://lesichkov.co.uk

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to use
the Software subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
 */

class SlowHash {

    public static $timesMultiplicator = 2500;

    public static function hash($string, $salt = "", $seconds = 3) {
        if ($salt == "") {
            $salt = uniqid(true);
        }
        
        $passes = $seconds * self::$timesMultiplicator;

        $safeString = base64_encode($string);
        $safeSalt = base64_encode($salt);

        $hash = $safeSalt . $safeString . $safeSalt;
        for ($i = 0; $i < $passes; $i++) {
            $hash = self::hashIt($i . $hash . $i, $i . $safeSalt . $i) . '-' . $safeSalt . '-' . $passes;
        }

        return str_rot13(base64_encode($hash));
    }

    private static function hashIt($str, $salt) {
        $strMulti = $salt . $str . $salt . $str . $salt . $str . $salt . $str . $salt . $str . $salt;
        $strBase64 = base64_encode($strMulti . $strMulti . $strMulti . $strMulti . $strMulti);
        $strReverse = str_rot13($strBase64 . $strBase64 . $strBase64 . $strBase64 . $strBase64);
        $hashMd5 = md5($strReverse . $strReverse . $strReverse . $strReverse . $strReverse);
        $hashSha1 = sha1($hashMd5 . $hashMd5 . $hashMd5 . $hashMd5 . $hashMd5);
        return $hashSha1;
    }

    public static function equals($string, $hash) {
        list($hashorig, $salt, $passes) = explode('-', base64_decode(str_rot13($hash)));
        $seconds = $passes / self::$timesMultiplicator;
        $newHash = self::hash($string, base64_decode($salt), $seconds);

        if ($newHash == $hash) {
            return true;
        }
        return false;
    }

}
?>
