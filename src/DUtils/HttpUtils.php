<?php

namespace DUtils;


class HttpUtils{

    /**
     * @param $url
     * @param array $options
     * @return string
     */
    public static function get($url,$options = []){

        $headers = [
            "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
            "Cache-Control:no-cache",
            "Connection:close",
            "User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.94 Safari/537.36"
        ];

        if (isset($options['headers']))
            $headers = array_merge($headers,$options['headers']);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if (isset($options['gzip'])){
            curl_setopt($ch, CURLOPT_ENCODING , "gzip");
            $headers[] = "Accept-Encoding:gzip, deflate, sdch";
        }

        $paginaWeb = curl_exec($ch);
        curl_close($ch);

        return $paginaWeb;

    }


}