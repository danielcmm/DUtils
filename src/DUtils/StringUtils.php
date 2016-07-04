<?php

namespace DUtils;

class StringUtils {

    public static function getDomainFromEmail($email) {

        if (empty($email))
            return "";

        $domain = substr(strrchr($email, "@"), 1);

        return $domain;
    }

    public static function maskZipCodeBR($cep) {

        if (strlen($cep) == 8) {
            $parte1 = substr($cep, 0, 2);
            $parte2 = substr($cep, 2, 3);
            $parte3 = substr($cep, 5, 3);

            return "$parte1.$parte2-$parte3";
        } else if (strlen($cep) == 10) {
            return $cep;
        }

        return "";

    }

    public static function maskPersonPinBR($cpf) {

        if (strlen($cpf) > 0) {

            $parte1 = substr($cpf, 0, 3);
            $parte2 = substr($cpf, 3, 3);
            $parte3 = substr($cpf, 6, 3);
            $parte4 = substr($cpf, 9, 2);

            return "$parte1.$parte2.$parte3-$parte4";
        }

        return "";
    }

    public static function maskCompanyPinBR($cnpj) {

        if (strlen($cnpj) == 14) {

            $parte1 = substr($cnpj, 0, 2);
            $parte2 = substr($cnpj, 2, 3);
            $parte3 = substr($cnpj, 5, 3);
            $parte4 = substr($cnpj, 8, 4);
            $parte5 = substr($cnpj, 12, 2);

            return "$parte1.$parte2.$parte3/$parte4-$parte5";
        }

        return "";
    }

    /**
     * Deixa a string passada somente com numeros
     * @param $str
     * @return string
     */
    public static function alphaNumericOnly($str) {
        return preg_replace('@[^0-9a-zA-Z]@', '', $str);
    }

    public static function numbersOnly($str) {
        return preg_replace('@[^0-9]@', '', $str);
    }

    public static function validateCompanyPinBR($cnpj) {

        $cnpj = preg_replace("@[./-]@", "", $cnpj);
        if (strlen($cnpj) != 14 or !is_numeric($cnpj)) {
            return 0;
        }
        $j = 5;
        $k = 6;
        $soma1 = "";
        $soma2 = "";

        for ($i = 0; $i < 13; $i++) {
            $j = $j == 1 ? 9 : $j;
            $k = $k == 1 ? 9 : $k;
            $soma2 += ($cnpj{$i} * $k);

            if ($i < 12) {
                $soma1 += ($cnpj{$i} * $j);
            }
            $k--;
            $j--;
        }

        $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
        $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;
        return (($cnpj{12} == $digito1) and ($cnpj{13} == $digito2));

    }

    public static function validatePersonPinBR($cpf) {

        // Verifica se o número digitado contém todos os digitos
        $cpf = preg_replace('@[^0-9]@', '', $cpf);

        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
            return false;
        } else { // Calcula os números para verificar se o CPF é verdadeiro


            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    public static function validatePhoneNumberBR($numTelefone){

        $numTelefone = self::numbersOnly($numTelefone);

        if ((strlen($numTelefone) == 10 || strlen($numTelefone) == 11) && is_numeric($numTelefone)){
            return true;
        }

        return false;

    }

    public static function removeAccentuation($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
    }


}