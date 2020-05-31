<?php

function jalalyFolder(){
    return jalalyNow()->format('y-m');
}

function JalalyYMD($timestamp){
    return jalaly($timestamp)->format('Y/m/d');
}

function jalaly($timestamp){
    return \Morilog\Jalali\Jalalian::forge($timestamp);
}

function jalalyNow(){
    return \Morilog\Jalali\Jalalian::now();
}

function toStandardDatetime($datetime){
    preg_match('/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}/',$datetime,$standard);
    return $standard[0];
}
