<?php

define('HOST','localhost/xe');
define('USERNAME','BICOKNORBERT');
define('PASSWORD','Bajaga45');

function csatlakozas(){
    $con = oci_connect(USERNAME, PASSWORD, HOST);

    if (!$con) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    return $con;
}