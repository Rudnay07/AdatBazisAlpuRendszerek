<?php
require_once("connection.php");
include_once("Lecek/fej.php");
$conn = csatlakozas();
$email = $_SESSION['loghirdeto'];

$sql = "SELECT * FROM HIRDETO WHERE email=:email";
$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':email', $email);

if (oci_execute($stid)) {
    $res = oci_fetch_array($stid, OCI_ASSOC);
    if ($res) {
        $name = $res['NEV'];
        $id= $res['FELHASZNALOID'];

    }
}

oci_free_statement($stid);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/lec.css">
    <link rel="stylesheet" href="css/hirdetesek.css">
    <title>Profil | Jelentkezések</title>


</head>
<body>
<div class="body-text">

    <h2 class="cim">
        Kedves: <?php if (!empty($name)) {echo $name;} ?>, Ön a következő hirdetéseket adta fel.
    </h2>
    <table class="styled-table">
        <thead>
        <tr>
            <th>Munka megnevezése</th>
            <th>Munka kategóriája</th>
            <th>Órabér</th>
            <th>Szükséges Nyelvtudás</th>
            <th>Hirdetés módosítása</th>
            <th>Hirdetés törlése</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT MUNKA.MUNKAID, MUNKA.MEGNEVEZES AS MUNKA, MUNKA.ORABER, MUNKA.SZUKSEGESNYELVTUDAS, KATEGORIA.MEGNEVEZES AS KATEGORIA FROM MUNKA LEFT JOIN KATEGORIA ON KATEGORIA.KATEGORIAID=MUNKA.KATEGORIAID WHERE hirdetoid=:id";
        $stid = oci_parse($conn, $query);
        oci_bind_by_name($stid, "id", $id);
        oci_execute($stid);

        while (($valtozo = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            echo '<tr>';
            echo '<td><a href="kikJelentkeztek.php?munka_id='.$valtozo['MUNKAID'].'">'. $valtozo['MUNKA'] .'</a></td>';
            echo '<td>'. $valtozo['KATEGORIA'] .'</td>';
            echo '<td>'. $valtozo['ORABER'] .'</td>';
            echo '<td>'. $valtozo['SZUKSEGESNYELVTUDAS'] .'</td>';
            echo '<td><a href="hirdetesModositasa.php?munka_id='.$valtozo['MUNKAID'].'">Módosít</a></td>';
            echo '<td><a href="hirdetesTorlese.php?munka_id='.$valtozo['MUNKAID'].'">X</a></td>';
            echo '</tr>';
        }
        oci_free_statement($stid);
        oci_close($conn);
        ?>
        </tbody>
    </table>
    <div class="feladas">
        <a href="hirdetesFeladasa.php?hirdeto_id=<?php echo $id;?>">Hirdetés Feladása</a>
    </div>


</body>
</html>
