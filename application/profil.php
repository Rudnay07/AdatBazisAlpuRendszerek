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
        $email = $res['EMAIL'];
        $nyelv = $res['NYELVTUDAS'];
        $szuliido = $res['SZULETESIIDO'];
        $veg = $res['VEGZETTSEG'];
        $id=$res['FELHASZNALOID'];

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
    <title>Profil</title>


</head>
<body>
<table></table>
<div class="body-text2">
    <td><img src="kepek/users.png" width="50%"></td>

    <h2>
        <td>Neve: <?php if (!empty($name)) {echo $name;} ?></td>
    </h2>
    <h2>
        <td>Email címe: <?php if (!empty($email)) {echo $email;} ?></td>
    </h2>
    <h2>
        <td>Nyelvtudas: <?php if (!empty($nyelv)) {echo $nyelv;} ?></td>
    </h2>
    <h2>
        <td>Születési idő: <?php if (!empty($szuliido)) {echo $szuliido;} ?></td>
    </h2>
    <h2>------------------------------------------------------</h2>
    <h2>
        <td>Itt tudod megtekinteni, </td>
        <h2>hogy eddig milyen munkákra <a href="Idejelentkezett.php">jelentkeztél</a></h2>

    </h2>
</div>
</table>

</body>
