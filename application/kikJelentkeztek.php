<?php
require_once("connection.php");
include_once("Lecek/fej.php");
$conn = csatlakozas();
/*$email = $_SESSION['loghirdeto'];

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

oci_free_statement($stid);*/
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
            <th>Jelentkező Neve</th>
            <th>Jelentkező E-mail címe</th>
            <th>Jelentkező Nyelvtudása</th>
            <th>Jelentkező CV-je</th>
            <th>Jelentkezés dátuma</th>
            <th>Jelentkezés törlése</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $id = $_GET['munka_id'];
        $query = "SELECT * FROM JELENTKEZETT LEFT JOIN KERESO ON KERESO.FELHASZNALOID=JELENTKEZETT.FELHASZNALOID WHERE JELENTKEZETT.MUNKAID=:id";
        $stid = oci_parse($conn, $query);
        oci_bind_by_name($stid, ':id', $id);


        oci_execute($stid);

        while (($valtozo = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            echo '<tr>';
            echo '<td>'. $valtozo['NEV'] .'</td>';
            echo '<td>'. $valtozo['EMAIL'] .'</td>';
            echo '<td>'. $valtozo['NYELVTUDAS'] .'</td>';
            echo '<td><button>Hello</button></td>';
            echo '<td>'. date('Y.m.d', strtotime($valtozo['DATUM'])).'</td>';
            echo '<td><a href="jelentkezoTorlese.php?jelentkezoid='.$valtozo['JELENTKEZETTID'].'">X</a></td>';
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
