<?php

namespace DUtils;

class EnvironmentUtils{

    public static function getProtocol(){

        $isSecure = false;
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $isSecure = true;
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
            $isSecure = true;
        }

        return $isSecure ? 'https' : 'http';

    }

    public static function getEnvironmentPath(){

        return static::getProtocol() . "://" .  $_SERVER['SERVER_NAME'];

    }


}