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
    $sql = "SELECT CEG.CegNev FROM MUNKA 
        JOIN HIRDETO ON MUNKA.HirdetoID = HIRDETO.FelhasznaloID 
        JOIN CEG ON HIRDETO.CegID = CEG.CegID 
        WHERE MUNKA.MUNKAID=:id";

    // Prepare the statements
    $stid = oci_parse($con, $query);
    $stmt = oci_parse($con, $sql);

    // Execute the first statement
    oci_execute($stid);

    echo '<div class="cards">';

    // Fetch the results and define columns to fetch for the second statement
    while (($valtozo = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) !=false) {
        oci_bind_by_name($stmt, "id", $valtozo["MUNKAID"]);
        oci_execute($stmt);
        $ceg = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS);

        echo '<div class="card">';
        echo '<div class="card-content">';
        echo '<h2>'. $valtozo["MEGNEVEZES"] .'</h2>';
        echo '<p>Szükséges nyelvtudás: '. $valtozo["SZUKSEGESNYELVTUDAS"] .'</p>';
        echo '<p>Órabér: '. $valtozo["ORABER"] .'Ft</p>';
        echo '<p>Hirdető cég neve: '. $ceg["CEGNEV"] .'</p>';
        echo '</div>';
        $munka_id=$valtozo['MUNKAID'];
        echo '<div class="card-a"><a class="card__link" href="jelentkezzet.php?munka_id=' .  $munka_id. '"> Jelentkezek</a></div>';
        echo '</div>';
    }
    echo '</div>';

    oci_free_statement($stmt);
    oci_free_statement($stid);
    oci_close($con);


    ?>
     </div>
</body>
</html>
