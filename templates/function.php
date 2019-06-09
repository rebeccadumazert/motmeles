<?php

function debug($variable){
    echo '<pre>' . print_r($variable, true) . '</pre>';

}

//genere une chaine de caractere en random pour le confirmation token

function str_random($length){
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    // code de chiffrement
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}
