<?php

use Carbon\Carbon;

function getDateForNotification($date){
    $created_at = \Carbon\Carbon::parse($date);   

    $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    $fecha = $created_at->day.' '.$meses[($created_at->month)-1].". ".$created_at->year;
   
    return $fecha;
}
function getSmallDateWithHour($date)
{
    $created_at = Carbon::parse($date);

    $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    $fecha = $created_at->day . ' ' . $meses[($created_at->month) - 1] . ". " . $created_at->year . ". " . $created_at->format('g:i A');

    return $fecha;
}

function getDateHourForNotification($date){
    $created_at = \Carbon\Carbon::parse($date);   

    $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    $fecha = $created_at->day.' '.$meses[($created_at->month)-1]." de ".$created_at->year." a las ".$created_at->format('g:i A');
   
    return $fecha;
}


function active($url){
   // dd(($url));
    return $url = request()->is($url) ? 'active' : '';
}

function extension($file){
    $exten = explode(".", $file);
    $num_exten=count($exten);
    $str_exten = $exten[$num_exten-1];
    return $str_exten;
}

function getBgColorDocument($file, $num=0){
    if ($num > 1 ) {
        return "bg-secondary";
    } else {
        if ( extension($file) == "pdf" ) {
            return "bg-danger";
        } elseif ( extension($file) == "doc" or extension($file) == "docx" ) {
            return "bg-info";
        } elseif ( extension($file) == "xls" or extension($file) == "xlsx" ) {
            return "bg-success";
        } else {
            return "bg-warning";
        }
    }

}

function getTotalSizeFiles($logfiles){

    if (count($logfiles) > 1 ) {
        $size=0;
        foreach ($logfiles as $key => $value) {
            $size=number_format(($value->size / 1048576),2)+$size;
        }
        return $size;
    } else {
       return number_format(($logfiles->first()->size / 1048576),2);
    }

}

function getBgIconDocument($file, $num=0){
    if ($num > 1 ) {
        return "far fa-copy";
    } else {
        if ( extension($file) == "pdf" ) {
            return "far fa-file-pdf";
        } elseif ( extension($file) == "doc" or extension($file) == "docx" ) {
            return "far fa-file-word";
        } elseif ( extension($file) == "xls" or extension($file) == "xlsx" ) {
            return "far fa-file-excel";
        } else {
            return "far fa-file";
        }
    }
}

function sanear_string($string)
{ 
    $string = trim($string); 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    ); 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    ); 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    ); 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    ); 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    ); 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("/", "¨", "º", "-", "~",
             "#", "@", "|", "!", "",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "<code>", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             "."),
        '',
        $string
    );
    $string = str_replace(
        array(" "),
        '_',
        $string
    );
    return strtolower($string);
}