<?php
require_once("connection.php");
session_start();
$conn = csatlakozas();
$email = "rudy@gmail.com";

$sql = "SELECT * FROM KERESO WHERE email=:email";
$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':email', $email);

if(oci_execute($stid)){
    $res = oci_fetch_array($stid, OCI_ASSOC);
    if($res){
        $name = $res['NEV'];
        echo "Név: " . $name;
    } else {
        echo "Nincs találat.";
    }
} else {
    $error = oci_error($stid);
    echo "Hiba történt az adatbázis lekérdezés során: " . $error['message'];
}

oci_free_statement($stid);
oci_close($conn);
?>
