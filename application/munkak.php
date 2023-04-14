<?php

require_once("connection.php");
include_once ("Lecek/fej.php");
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;900&family=Ubuntu&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/lec.css">
    <link rel="stylesheet" href="css/munkak.css">

    <title>Document</title>

</head>
<body>

 <div class="container">

    <?php

    $kategoria_id = $_GET['kategoria_id'];
    $con = csatlakozas();

    $query = "SELECT megnevezes FROM kategoria WHERE kategoriaid='$kategoria_id '";
    $stid = oci_parse($con, $query);
    oci_execute($stid);

    $valtozo = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);

    echo '<h1>' . $valtozo["MEGNEVEZES"] . '</h1>';


    $query = "SELECT * FROM MUNKA WHERE kategoriaid='$kategoria_id '";

    //// -- lekerdezzuk a tabla tartalmat
    $stid = oci_parse($con, $query);


    oci_execute($stid);
    echo '<div class="cards">';
    //// -- ujra vegrehajtom a lekerdezest, es kiiratom a sorokat
    while ( ($valtozo = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) !=false) {
        echo '<div class="card">';
        echo '<div class="card-content">';
        echo '<h2>'. $valtozo["MEGNEVEZES"] .'</h2>';
        echo '<p>Szükséges nyelvtudás: '. $valtozo["SZUKSEGESNYELVTUDAS"] .'</p>';
        echo '<p>Órabér: '. $valtozo["ORABER"] .'Ft</p>';
        echo '</div>';
        echo '<div class="card-a"><a class="card__link" href="#"> Részletek</a></div>';
        echo '</div>';
    }
    echo '</div>';


    oci_close($con);


    ?>
     </div>
</body>
</html>
