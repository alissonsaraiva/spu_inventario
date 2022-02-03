<?php

namespace App\Libraries;

class Util
{
    // This function converts a string into slug format
    function limpa_numero_processo($string = null)
    {
    
    $string = utf8_encode($string);
    
        $string = trim($string);
    
        $string = str_replace(' ', '', $string);
    
        $string = str_replace('_', '', $string);
    
        $string = str_replace('/', '', $string);
    
        $string = str_replace('-', '', $string);
    
        $string = str_replace('(', '', $string);
    
        $string = str_replace(')', '', $string);
    
        $string = str_replace('.', '', $string);

        return $string;
    }
}