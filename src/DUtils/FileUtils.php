<?php

namespace DUtils;

class FileUtils{


    public static function getFileName($filePath){

        $pos = strrpos($filePath,"/");
        if ($pos !== FALSE){
            return substr($filePath,($pos+1));
        }

        return "";

    }

    public static function addSuffixOnFileName($fileName,$suffix){

        $posUltimoPonto = strripos($fileName,".");
        $nomeSemExtensao = substr($fileName,0,$posUltimoPonto);
        $nomeFinal = $nomeSemExtensao . "_$suffix" . substr($fileName,$posUltimoPonto);

        return $nomeFinal;

    }

}