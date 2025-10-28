<?php

if (!function_exists('farsi')) {
    function farsi($value): string
    {
        $english = ['0','1','2','3','4','5','6','7','8','9'];
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        return str_replace($english, $persian, (string)$value);
    }
}

if (!function_exists('english')) {
    function english($value): string
    {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];
        return str_replace($persian, $english, (string)$value);
    }
}
