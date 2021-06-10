<?php
// src/Service/TwigHelper.php
namespace App\Service;


class TwigHelper
{
    function JSONDecode($json)
    {
        return json_decode($json, true);
    }

    function URLDecode($urlEncodedString)
    {
        return urldecode($urlEncodedString);
    }

    function SplitText($text) : array
    {
        return explode("\n", $text);
    }
}