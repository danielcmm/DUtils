<?php

namespace DUtils;

class CurrencyUtils{


    public static function prepareToView($value){

        if ($value != 0 && empty($value))
            return "";

        return number_format(static::getCurrencyInUSFormat($value), 2, ',', '.');
    }

    /**
     * Prepara um valor para ser persistido na base de dados
     * @param $value
     * @return int|string
     */
    public static function prepareToPersist($value){

        if (empty($value))
            return 0;

        $value = str_replace(["R$"," "],"",$value);
        $valueFormatado  = static::getCurrencyInUSFormat($value);

        if (!is_numeric($valueFormatado)){
            return 0;
        }

        return number_format($valueFormatado, 2, '.', '');

    }

    public static function getCurrencyInUSFormat($value){

        $value = "$value";

        if (strlen($value) >=3 && ($value[strlen($value)-2] == "." || $value[strlen($value)-2] == ","))
            $value .= "0";

        $newValue = str_replace(",","",$value);
        $newValue = str_replace(".","",$newValue);

        if ($newValue == $value) //Significa que não tinha pontos ou virgulas, entao consideramos como um inteiro
            $newValue .= "00";

        return substr($newValue,0,-2) . '.' . substr($newValue,strlen($newValue)-2);

    }


}