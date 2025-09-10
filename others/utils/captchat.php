<?php
class Captchat
{
    function generarCodigo()
    {
        $codigo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        return $codigo;
    }
}