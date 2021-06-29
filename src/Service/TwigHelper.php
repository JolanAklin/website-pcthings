<?php
//MIT License

//Copyright (c) 2021 Jolan Aklin and Yohan Zbinden

//Permission is hereby granted, free of charge, to any person obtaining a copy
//of this software and associated documentation files (the "text editor"), to deal
//in the Software without restriction, including without limitation the rights
//to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
//copies of the Software, and to permit persons to whom the Software is
//furnished to do so, subject to the following conditions:

//The above copyright notice and this permission notice shall be included in all
//copies or substantial portions of the Software.

//THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
//IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
//FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
//AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
//LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
//OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
//SOFTWARE.


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

    function FormatText($text) : string
    {
        $text = htmlentities($text);

        $patterns = array();
        $patterns[0] = '/&amp;bg(#[a-z0-9]{6})&amp;(.+?(?=&amp;bg&amp;))&amp;bg&amp;/i'; // flag i = case insensitive | &amp; = & | change background color | match &bg#ffffff&some text&bg&
        $patterns[1] = '/&amp;fg(#[a-z0-9]{6})&amp;(.+?(?=&amp;fg&amp;))&amp;fg&amp;/i'; // flag i = case insensitive | &amp; = & | change text color | match &fg#ffffff&some text&fg&
        $patterns[2] = '/\*\*(.+?(?=\*\*))\*\*/i'; // bold text | match **text**
        $patterns[3] = '/\*(.+?(?=\*))\*/i'; // italic text | match *text*
        $patterns[4] = '/\[(.+?(?=\]))\]\((.+?(?=\s&quot;))\s&quot;(.+?(?=&quot;\)))&quot;\)/i'; // &quot; = " | match [Duck Duck Go](https://duckduckgo.com "The best search engine for privacy")
        $patterns[5] = '/&amp;danger&amp;(.+?(?=&amp;danger&amp;))&amp;danger&amp;/i'; // match &danger&text&danger&
        $patterns[6] = '/&amp;warn&amp;(.+?(?=&amp;warn&amp;))&amp;warn&amp;/i'; // match &warn&text&warn&
        $patterns[7] = '/&amp;info&amp;(.+?(?=&amp;info&amp;))&amp;info&amp;/i'; // match &info&text&info&
        $patterns[8] = '/&amp;success&amp;(.+?(?=&amp;success&amp;))&amp;success&amp;/i'; // match &success&text&success&

        $replacements = array();
        $replacements[0] = '<span style="background-color: $1;">$2</span>';
        $replacements[1] = '<span style="color: $1;">$2</span>';
        $replacements[2] = '<span style="font-weight: bold;">$1</span>';
        $replacements[3] = '<span style="font-style: italic;">$1</span>';
        $replacements[4] = '<a class="link" href="$2" title="$3" target="_blank">$1</a>';
        $replacements[5] = '<span class="alert alert-danger">$1</span>';
        $replacements[6] = '<span class="alert alert-warning">$1</span>';
        $replacements[7] = '<span class="alert alert-info">$1</span>';
        $replacements[8] = '<span class="alert alert-success">$1</span>';

        return preg_replace($patterns, $replacements, $text);
    }
}