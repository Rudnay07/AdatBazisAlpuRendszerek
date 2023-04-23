<?php

require_once("connection.php");
include_once("Lecek/fej.php");

$conn = csatlakozas();
$message = "";
$hirdet_id = $_GET['hirdeto_id'];

if(isset($_POST['cegreg'])){
    $cegnev = $_POST['cegnev'];
    $dolgozok = $_POST['dolgozok'];

    $sql = "SELECT ceg_seq.nextval FROM dual";
    $stid = oci_parse($conn, $sql);
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC);
    $cegid = $row['NEXTVAL'];


    $stmt = oci_parse($conn, "INSERT INTO CEG (CegID, Cegnev, ALKALMAZOTTAKSZAMA) VALUES (:cegid, :name, :dolgozok)");
    oci_bind_by_name($stmt, ":cegid", $cegid);
    oci_bind_by_name($stmt, ":name", $cegnev);
    oci_bind_by_name($stmt, ":dolgozok", $dolgozok);

    if (oci_execute($stmt)) {
        // Sikeres regisztráció, továbbítás a bejelentkező oldalra
        header("Location: profil.php");
    } else {
        $message = "Valami hiba történt a cég regisztrációja során";
    }
    $stmt = oci_parse($conn, "UPDATE HIRDETO SET CEGID=:cegid WHERE FELHASZNALOID=:id");
    oci_bind_by_name($stmt, ":cegid", $cegid);
    oci_bind_by_name($stmt, ":id", $hirdet_id);

    if (oci_execute($stmt)) {
        // Sikeres regisztráció, továbbítás a bejelentkező oldalra
        header("Location: profil.php");
    } else {
        $message = "Valami hiba történt a cég regisztrációja során";
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
    <link rel="stylesheet" href="css/cegreg.css">
    <title>Main</title>

</head>
<body>
<div class="main-div">
    <div class="ceg-register">
        <form method="POST" autocomplete="off">
            <h1>Cég regisztrálása</h1>
            <?php if ($message != "") { ?>
            <p><?php echo $message; ?></p>
        <?php } ?>
            <input type="text" placeholder="Cég neve" name="cegnev"/>
            <input type="number" placeholder="Cég dolgozóinak száma" name="dolgozok"/>

            <button type="submit" name="cegreg">Cég regisztrálása</button>
            <p></p>
            <a href="profil.php"<button type="submit">Vissza a profilra</button></a>


        </form>
    </div>
</div>

</body>
</html>
