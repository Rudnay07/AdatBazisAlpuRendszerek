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
        $id= $res['ID'];

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
            <th>Kategória</th>
            <th>Órabér</th>
            <th>Szükséges Nyelvtudás</th>
            <th>Jelentkezés törlése</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM JELENTKEZETT";
        $stid = oci_parse($conn, $query);
        oci_execute($stid);
        while (($valtozo = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
           
        }
        ?>
        </tbody>
    </table>
</body>
