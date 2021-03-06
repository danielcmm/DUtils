<?php

namespace DUtils;

class FileUtils{

    public static function isCsv($filePath){

        $arr = [
            'csv','txt'
        ];

        return in_array(self::getFileExtension($filePath),$arr);

    }

    public static function readCsv($file, $delimiter) {

        $result = [];
        $header = array();
        $aux = 0;

        $isUtf8 = mb_detect_encoding(file_get_contents($file)) == 'UTF-8';

        if (($handle = fopen($file, "r")) !== FALSE) {

            while (($data = fgetcsv($handle, 0, $delimiter)) !== FALSE) {

                $rowData = [];

                if ($aux == 0) {
                    foreach ($data as $headerColumn) {
                        if(!$isUtf8) {
                            $headerColumn = utf8_encode($headerColumn);
                        }
                        $headerColumn = StringUtils::replaceUTF8Accentuation($headerColumn);
                        $headerColumn = strtolower(StringUtils::removeAccentuation($headerColumn));
                        $header[] = $headerColumn;

                    }
                    $aux++;
                    continue;
                }

                foreach ($data as $idx => $coluna) {

                    if (isset($header[$idx])){
                        if(!$isUtf8){
                            $coluna = utf8_encode($coluna);
                        }
                        $rowData[$header[$idx]] = StringUtils::replaceUTF8Accentuation($coluna);
                    }

                }

                $result[] = $rowData;

            }

            fclose($handle);
        }

        return $result;


    }

    public static function readCsvHeader($file, $delimiter) {

        $header = array();
        $isUtf8 = mb_detect_encoding(file_get_contents($file)) == 'UTF-8';

        if (($handle = fopen($file, "r")) !== FALSE) {

            $data = fgetcsv($handle, 0, $delimiter);


            foreach ($data as $headerColumn) {
                if(!$isUtf8) {
                    $headerColumn = utf8_encode($headerColumn);
                }
                $headerColumn = StringUtils::replaceUTF8Accentuation($headerColumn);
                $headerColumn = strtolower(StringUtils::removeAccentuation($headerColumn));
                $header[] = $headerColumn;

            }
            fclose($handle);
        }

        return $header;


    }




    public static function getFileExtension($filePath){

        $pos = strrpos($filePath,".") + 1;
        return substr($filePath,$pos);

    }

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
