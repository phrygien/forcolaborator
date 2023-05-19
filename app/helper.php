<?php

if(!function_exists('get_formatted_date'))
{
    function get_formatted_date($date, $format)
    {
        $formattedDate = date($format, strtotime($date));
        return $formattedDate;
    }
}