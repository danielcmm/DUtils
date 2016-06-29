<?php

namespace DUtils;

class DateUtils {

    /**
     * Formata uma data para o padrao americano Y-m-d H:i:s, utilizado por padrao no MySQL
     * @param string $data
     * @return bool|int|null|string
     */
    static function prepareToPersist($data) {

        if (validarData($data)) {

            $dia = substr($data, 0, 2);
            $mes = substr($data, 3, 2);
            $data = $mes . "/" . $dia . substr($data, 5);

            $formato = strlen($data) <= 10 ? "Y-m-d" : "Y-m-d H:i:s";
            $data = strtotime($data);
            $data = date($formato, $data);

            return $data;

        } else
            return null;

    }

    /**
     * Pega uma data em formato americano e transforma no formato brasileiro
     * @param $dataMysql
     * @return string
     */
    static function prepareToView($dataMysql) {

        if (static::validarData($dataMysql)) {
            $data = substr($dataMysql, 8, 2) . "/" . substr($dataMysql, 5, 2) . "/" . substr($dataMysql, 0, 4);
            $data = $data . substr($dataMysql, 10);
            return $data;
        } else
            return null;

    }

    /**
     * Retorna o ano atual no formate de 4 digitos. Ex: 2012
     * @return string
     */
    static function getCurrentYear() {
        return date("Y");
    }

    static function getLastMonthYear() {

        $ano = getCurrentYear();
        $mesAnterior = getLastMonth();

        if ($mesAnterior == 12) {
            $ano--;
        }

        return $ano;

    }

    /**
     * Retorna a data atual em formato unix
     * @return number
     */
    static function getDataAtualUnix() {
        return time();
    }


    /**
     * Retorna o dia da semana de acordo com a data
     * @param $data
     * @return number
     */
    static function getDiaSemanaFromData($data) {

        $ano = substr($data, 0, 4) + 0;
        $mes = substr($data, 5, -3) + 0;
        $dia = substr($data, 8, 9) + 0;

        $diaSemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

        if ($diaSemana == 0)
            $diaSemana = 7;

        return $diaSemana;

    }

    /**
     * Retorna o dia da semana anterior ao atual
     * @return number
     */
    static function getDiaSemanaAnterior() {

        $diaAtual = date("N");
        $ontem = $diaAtual - 1;

        if ($diaAtual == 1)
            $ontem = 7;

        return $ontem;

    }

    static function getDiaSemanaSimples($intDiaSemana) {

        $arrDiaSemana = array(
            1 => "Segunda",
            2 => "Terça",
            3 => "Quarta",
            4 => "Quinta",
            5 => "Sexta",
            6 => "Sábado",
            7 => "Domingo");

        return $arrDiaSemana[$intDiaSemana];
    }

    static function getDiaSemanaCompleto($intDiaSemana) {

        $arrDiaSemana = array(
            1 => "segunda-feira",
            2 => "terça-feira",
            3 => "quarta-feira",
            4 => "quinta-feira",
            5 => "sexta-feira",
            6 => "sábado",
            7 => "domingo");

        return $arrDiaSemana[$intDiaSemana];
    }

    /**
     * Retorna a descricao abreviada do dia da semana
     * @param number $diaSemana
     * @return string
     */
    static function getDscDiaSemana($diaSemana) {

        $arrDiaSemana = array(
            1 => "SEG",
            2 => "TER",
            3 => "QUA",
            4 => "QUI",
            5 => "SEX",
            6 => "SAB",
            7 => "DOM");

        return $arrDiaSemana[$diaSemana];

    }

    /**
     * Retorna a hora atual, no format H:i. Ex: 22:50
     */
    static function getHoraAtual() {
        return Date("H:i");
    }

    static function getInicioMesAnterior() {

        return getLastMonthYear() . "-" . getLastMonth() . "-01";

    }

    /**
     * Retorna a data de início do dia anterior
     */
    static function getInicioDiaAnterior() {

        $diaAtual = date("d-m-Y");
        $inicioOntem = strtotime($diaAtual . " -1 day");
        return $inicioOntem;

    }

    /**
     * Retorna o mes anterior ao atual
     * @return Ambigous <number, string>
     */
    static function getLastMonth() {

        $aux = getMesAtual();

        if ($aux == 1) {
            $aux = 12;
        } else {
            $aux--;
        }

        return $aux;

    }

    /**
     * Retorna o mes atual de 1 a 12
     * @return string
     */
    static function getMesAtual() {

        return date("n");

    }

    static function getProximoMes($mesReferencia) {

        $proximo = ++$mesReferencia;

        if ($proximo == 13) {
            $proximo = 1;
        }

        return $proximo;

    }

    static function getProximoAnoPorMesReferencia($mesReferencia) {

        $proximoMes = getProximoMes($mesReferencia);
        $ano = getCurrentYear();

        if ($proximoMes == 1) {
            ++$ano;
        }

        return $ano;

    }


    /**
     * Verifica se o horário alvo está entre o horário de início e o de fim
     * @param $horarioInicio
     * @param $horarioFim
     * @param $horarioAlvo
     */
    static function isEntreHorarios($horarioInicio, $horarioFim, $horarioAlvo) {

        if (!isPreenchido($horarioInicio) || !isPreenchido($horarioFim) || !isPreenchido($horarioAlvo))
            return false;

        $inicioUnix = strtotime($horarioInicio);
        $fimUnix = strtotime($horarioFim);
        $alvoUnix = strtotime($horarioAlvo);

        //Se esta condição for verdadeira, significa que a hora de fim é depois de meia noite do prox dia
        if ($fimUnix < $inicioUnix) {
            $fimUnix = strtotime($horarioFim . "+ 1 day");
        }

        $diferencaInicio = ($alvoUnix - $inicioUnix);
        $diferencaFim = ($alvoUnix - $fimUnix);
        return ($diferencaInicio >= 0 && $diferencaFim <= 0);

    }

    static function isEntreDatas($data1, $data2, $dataAlvo) {

        return $dataAlvo >= $data1 && $dataAlvo <= $data2;

    }

    /**
     * Verifica se um determinado mes/ano de comparação é igual ou posterior ao mês/ano de referencia
     * @param int $mesReferencia
     * @param int $anoReferencia
     * @param int $mesComparacao
     * @param int $anoComparacao
     * @return boolean
     */
    static function isDataIgualOuPosterior($mesReferencia, $anoReferencia, $mesComparacao, $anoComparacao) {

        if ($anoComparacao > $anoReferencia) {
            return true;
        }

        if ($anoComparacao == $anoReferencia) {

            if ($mesComparacao >= $mesReferencia) {
                return true;
            }

        }

        return false;

    }

    /**
     * Verifica se um determinado mes/ano de comparação é posterior ao mês/ano de referencia
     * @param int $mesReferencia
     * @param int $anoReferencia
     * @param int $mesComparacao
     * @param int $anoComparacao
     * @return boolean
     */
    static function isDataPosterior($mesReferencia, $anoReferencia, $mesComparacao, $anoComparacao) {

        if ($anoComparacao > $anoReferencia) {
            return true;
        }

        if ($anoComparacao == $anoReferencia) {

            if ($mesComparacao > $mesReferencia) {
                return true;
            }

        }

        return false;

    }


    /**
     * Verifica se duas datas estao no mesmo dia
     * As datas devem estar no formado Y-m-d(Americano)
     * @param $data1
     * @param $data2
     * @return bool
     */
    static function isMesmoDia($data1, $data2) {

        //Retira as horas...
        $data1 = substr($data1, 0, 10);
        $data2 = substr($data2, 0, 10);

        return $data1 == $data2;

    }

    /**
     * Retorna o nome do mês
     * @param int $id_mes
     * @return string
     */
    static function getNomeMes($id_mes) {

        switch ($id_mes) {

            case 1 :
                return "Janeiro";
                break;
            case 2 :
                return "Fevereiro";
                break;
            case 3 :
                return "Março";
                break;
            case 4 :
                return "Abril";
                break;
            case 5 :
                return "Maio";
                break;
            case 6 :
                return "Junho";
                break;
            case 7 :
                return "Julho";
                break;
            case 8 :
                return "Agosto";
                break;
            case 9 :
                return "Setembro";
                break;
            case 10 :
                return "Outubro";
                break;
            case 11 :
                return "Novembro";
                break;
            case 12 :
                return "Dezembro";
                break;

        }

    }

    static function getNomeMesAbreviado($id_mes) {

        switch ($id_mes) {

            case 1 :
                return "JAN";
                break;
            case 2 :
                return "FEV";
                break;
            case 3 :
                return "MAR";
                break;
            case 4 :
                return "ABR";
                break;
            case 5 :
                return "MAI";
                break;
            case 6 :
                return "JUN";
                break;
            case 7 :
                return "JUL";
                break;
            case 8 :
                return "AGO";
                break;
            case 9 :
                return "SET";
                break;
            case 10 :
                return "OUT";
                break;
            case 11 :
                return "NOV";
                break;
            case 12 :
                return "DEZ";
                break;

        }

    }

    /**
     * @param $dscMes
     * @param bool $completo - Retorna o número do mês com 2 digitos
     * @return int
     */

    static function getIntMes($dscMes, $completo = false) {

        switch (strtoupper($dscMes)) {

            case 'JAN' :
                $retorno = 1;
                break;

            case 'FEV' :
                $retorno = 2;
                break;

            case 'MAR' :
                $retorno = 3;
                break;

            case 'ABR' :
                $retorno =  4;
                break;

            case 'MAI' :
                $retorno =  5;
                break;

            case 'JUN' :
                $retorno =  6;
                break;

            case 'JUL' :
                $retorno =  7;
                break;

            case 'AGO' :
                $retorno =  8;
                break;

            case 'SET' :
                $retorno =  9;
                break;

            case 'OUT' :
                $retorno =  10;
                break;

            case 'NOV' :
                $retorno =  11;
                break;

            case 'DEZ' :
                $retorno =  12;
                break;
        }

        if (($completo) && ($retorno <= 9)) {
            $retorno = "0$retorno";
        }
        return $retorno;
    }


    /**
     * Retorna um horário em formato de leitura
     * @param $tempo
     * @param $formato
     */
    static function getTempoExtenso($tempo, $formato) {

        $strFinal = "";

        switch ($formato) {

            case "S": //Segundos

                if ($tempo >= 60) {

                    $qntMinutos = ($tempo / 60);
                    $strFinal .= getTempoExtenso($qntMinutos, "M");

                    $resto = ($tempo % 60);

                    if ($resto > 0) {
                        $strFinal .= " e " . (int)$resto;
                    }


                } else {

                    $strFinal .= (int)$tempo;

                }

                $strFinal .= " segundos";

                break;

            case "M": //Minutos

                if ($tempo >= 60) {

                    $qntHoras = ($tempo / 60);
                    $strFinal .= getTempoExtenso($qntHoras, "H");

                    $resto = ($tempo % 60);

                    if ($resto > 0) {
                        $strFinal .= " e " . (int)$resto;
                    }

                } else {

                    $strFinal .= (int)$tempo;

                }


                $strFinal .= " minuto" . ((int)$tempo > 1 ? "s" : "");

                break;
            case "H": //Minutos

                $strFinal .= (int)$tempo . " hora" . ((int)$tempo > 1 ? "s" : "");

                break;
        }

        return $strFinal;

    }

    /**
     * Verifica se uma data eh valida.
     * Ignora o horario, caso exista
     * Formato: DD/MM/YYYY
     * @param unknown_type $date
     * @return boolean
     */
    static function validarData($date) {

        if (strlen($date) > 10)
            $date = substr($date, 0, 10);

        if (!isset($date) || $date == "") {
            return false;
        }

        if (stripos($date, "/") !== false) {

            list($dd, $mm, $yy) = explode("/", $date);
            if ($dd != "" && $mm != "" && $yy != "") {
                if (is_numeric($yy) && is_numeric($mm) && is_numeric($dd)) {
                    return checkdate($mm, $dd, $yy);
                }
            }
            return false;
        } else if (stripos($date, "-") !== false) {

            list($yy, $mm, $dd) = explode("-", $date);

            if (is_numeric($yy) && is_numeric($mm) && is_numeric($dd)) {
                return checkdate($mm, $dd, $yy);
            }
            return false;
        }

        return false;
    }

}