<?php

require_once("connection.php");
include_once ("Lecek/fej.php");


$conn = csatlakozas();
$email = $_SESSION['loguser'];

$sql = "SELECT * FROM KERESO WHERE email=:email";
$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':email', $email);

if (oci_execute($stid)) {
    $res = oci_fetch_array($stid, OCI_ASSOC);
    if ($res) {
        $name = $res['NEV'];
    }}
oci_free_statement($stid);
oci_close($conn);

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/lec.css">
    <title>Main</title>
    <div class="body-text">
        <?php
        $ki = "Üdvözlöm " . $name . "!";
        if (!empty($name)) {
            echo '<h1>' .$ki . '</h1>';
        }
        ?>

        <h2></h2>
        <p></p>
    </div>

</head>
<body>

</body>
