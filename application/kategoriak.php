<?php

require_once("connection.php");
include_once ("Lecek/fej.php");

$conn = csatlakozas();
$query = "SELECT kategoriaid,megnevezes FROM KATEGORIA";
$stid = oci_parse($conn, $query);

oci_execute($stid);

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/lec.css">
    <link rel="stylesheet" href="css/kategoriak.css">

    <title>Document</title>

</head>
<body>
        <div class="felso">
            <h2>Válaszd ki melyik kategóriában szeretnél munkát keresni!</h2>
            <?php

                while ( ($valtozo = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) !=false) {
                    $kategoria_id = $valtozo['KATEGORIAID'];
                    $item = $valtozo['MEGNEVEZES'];
                    echo '<ul>';
                    echo '<li><a href="munkak.php?kategoria_id=' .  $kategoria_id . '" class="gradient-text">' . $item . '</a></li>';
                    echo '</ul>';
                }

            ?>
        </div>
</body>
</html>
