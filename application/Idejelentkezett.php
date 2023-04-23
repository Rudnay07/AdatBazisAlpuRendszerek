Roland Rudnay
<?php
require_once("connection.php");
include_once("Lecek/fej.php");
$conn = csatlakozas();
$email = $_SESSION['loguser'];

$sql = "SELECT * FROM KERESO WHERE email=:email";
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
    <title>Profil | Jelentkezések</title>


</head>
<body>
<div class="body-text">

    <h2>
        <td>Kedves: <?php if (!empty($name)) {echo $name;} ?>, Őn a következő Munkákra adta be eddig a jelentkezést</td>
    </h2>
    <table class="styled-table">
        <thead>
        <tr>
            <th>Munka megnevezés</th>
            <th>Mikor jelentkeztél</th>
            <th>Órabér</th>
            <th>Szükséges Nyelvtudás</th>
            <th>Jelentkezés törlése</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM JELENTKEZETT WHERE FELHASZNALOID='$id'";
        $stid = oci_parse($conn, $query);
        oci_execute($stid);
        $valtozo=oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
        $ertek=$valtozo['MUNKAID'];
        $ido=$valtozo['DATUM'];
        while (($valtozo = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false ) {
            echo "<tr>";

            $ertek = $valtozo['MUNKAID'];

            $query = "SELECT * FROM MUNKA WHERE MUNKAID='$ertek'";
            $stid2 = oci_parse($conn, $query);
            oci_execute($stid2);

            while (($valtozo2 = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)) != false ) {
                echo "<td >". $valtozo2['MEGNEVEZES']."</td>";
                echo "<td >". date('Y.m.d', strtotime($ido)) ."</td>";
                echo "<td >". $valtozo2['ORABER']."</td>";
                echo "<td >". $valtozo2['SZUKSEGESNYELVTUDAS']."</td>";
                $id=$valtozo['JELENTKEZETTID'];
                echo $id;
                echo "<td> <a href='munkaroltorles.php?jelentkezettid'" .$valtozo['JELENTKEZETTID']."'>&#9747</a></td>";
            }
            oci_free_statement($stid2);
            echo "</tr>";
        }


        oci_free_statement($stid);
        oci_close($conn);

        ?>
        </tbody>
    </table>
</body>
</html>