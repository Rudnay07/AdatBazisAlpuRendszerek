<?php

require_once("connection.php");
include_once("Lecek/fej.php");


$conn = csatlakozas();
if(isset($_SESSION['loguser'])){
    $email = $_SESSION['loguser'];

    $sql = "SELECT * FROM KERESO WHERE email=:email";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ':email', $email);

    if (oci_execute($stid)) {
        $res = oci_fetch_array($stid, OCI_ASSOC);
        if ($res) {
            $name = $res['NEV'];
            $email = $res['EMAIL'];
            $nyelv = $res['NYELVTUDAS'];
            $szuliido = $res['SZULETESIIDO'];
            $veg = $res['VEGZETTSEG'];
            $id=$res['FELHASZNALOID'];

        }
    }

    oci_free_statement($stid);
    oci_close($conn);
}
if(isset($_SESSION['loghirdeto'])){
    $email = $_SESSION['loghirdeto'];

    $sql = "SELECT Hirdeto.HIRDETOID, Hirdeto.NEV, Hirdeto.EMAIL, Hirdeto.CEGID, CEG.CEGNEV FROM Hirdeto LEFT JOIN CEG ON CEG.CEGID=Hirdeto.CEGID WHERE email=:email";
    $stid = oci_parse($conn, $sql);

    oci_bind_by_name($stid, ':email', $email);

    if (oci_execute($stid)) {
        $res = oci_fetch_array($stid, OCI_ASSOC);
        if ($res) {
            $id=$res['HIRDETOID'];
            $name = $res['NEV'];
            $email = $res['EMAIL'];
            $cegid= null;
            if(isset($res['CEGID'])){
                $cegid = $res['CEGID'];
            }
            if($cegid === null){
                $ceg = "Nem tartozol egy céghez sem.";
            } else{
                $ceg=$res['CEGNEV'];
            }
        }
    }

    oci_free_statement($stid);
    oci_close($conn);
}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/lec.css">
    <title>Profil</title>


</head>
<body>
<table></table>
<div class="body-text2">
    <td><img src="kepek/users.png" width="50%"></td>
    <?php
        if(isset($_SESSION['loguser'])){
            echo '<h2>';
            echo '<td>Neve: ' .$name. '</td>';
            echo '</h2>';
            echo '<h2>';
            echo '<td>Email címe: ' .$email. '</td>';
            echo '</h2>';
            echo '<h2>';
            echo '<td>Nyelvtudas: ' .$nyelv. '</td>';
            echo '</h2>';
            echo '<h2>';
            echo '<td>Születési idő: ' .$szuliido. '</td>';
            echo '</h2>';
            echo '<h2>------------------------------------------------------</h2>';
            echo '<h2>';
            echo '<td>Itt tudod megtekinteni, </td>';
            echo '<h2>hogy eddig milyen munkákra <a href="Idejelentkezett.php">jelentkeztél</a></h2>';
            echo '</h2>';
        }
        if(isset($_SESSION['loghirdeto'])){
            echo '<h2>';
            echo '<td>Neve: ' .$name. '</td>';
            echo '</h2>';
            echo '<h2>';
            echo '<td>Email címe: ' .$email. '</td>';
            echo '</h2>';
            echo '<h2>';
            echo '<td>Cég neve: ' .$ceg. '</td>';
            echo '</h2>';
            echo '<h2>';
            echo '<h2>------------------------------------------------------</h2>';

            if($cegid !== null){
                echo '<h2>';
                echo '<td>Itt tudod megtekinteni, </td>';
                echo '<h2>hogy milyen munkákat <a href="hirdetesek.php">hirdettél</a>!</h2>';
                echo '</h2>';
            } else{
                echo '<h2>';
                echo '<td>Mivel még nem adta meg mely céghez tartozol, </td>';
                echo '<h2>itt felregisztrálhatod a <a href="cegRegister.php?hirdeto_id='. $id .'">céged</a>!</h2>';
                echo '</h2>';
            }

        }
    ?>

</div>
</table>

</body>
