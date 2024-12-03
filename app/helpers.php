<?php

if(!function_exists('formatNumber')) {
    function formatNumber($number)
    {
        $number = floatval($number);
        if(floor($number) == $number){
            return number_format($number, 0 , '.', '');
        }else{
            return rtrim(rtrim(number_format($number, 2, '.', ''), '0'), '.');
        }
    }
}