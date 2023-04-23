<?php

require_once("connection.php");
include_once("Lecek/fej.php");

$conn = csatlakozas();
$message = "";
$hirdeto_id = $_GET['hirdeto_id'];

if(isset($_POST['hirdet'])){
    $munkaNev = $_POST['name'];
    $oraber = $_POST['oraber'];
    $nyelv = $_POST['language'];
    $kategoria = $_POST['kategoria'];


    $stmt = oci_parse($conn, "INSERT INTO MUNKA (MUNKAID, MEGNEVEZES, SZUKSEGESNYELVTUDAS, ORABER, HIRDETOID, KATEGORIAID) VALUES (munka_seq.nextval, :name, :nyelv, :oraber, :hid, :kid)");
    oci_bind_by_name($stmt, ":name", $munkaNev);
    oci_bind_by_name($stmt, ":oraber", $oraber);
    oci_bind_by_name($stmt, ":nyelv", $nyelv);
    oci_bind_by_name($stmt, ":hid", $hirdeto_id);
    oci_bind_by_name($stmt, ":kid", $kategoria);

    if (oci_execute($stmt)) {
        // Sikeres regisztráció, továbbítás a bejelentkező oldalra
        header("Location: hirdetesek.php");
    } else {
        $message = "Valami hiba történt a cég regisztrációja során";
    }


}
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
            <input type="text" placeholder="Munka megnevezése" name="name"/>
            <input type="number" placeholder="Órabér (Ft-ban)" name="oraber"/>
            <input type="text" placeholder="Szükséges nyelvtudás" name="language"/>
            <select  name="kategoria">
                <?php

                $conn = csatlakozas();
                $query = "SELECT kategoriaid, megnevezes FROM KATEGORIA";
                $stid = oci_parse($conn, $query);

                oci_execute($stid);
                while (($valtozo = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    echo '<option value="'. $valtozo['KATEGORIAID'] .'">'. $valtozo['MEGNEVEZES'] .'</option>';
                }

                oci_close($conn);
                ?>
            </select>

            <button type="submit" name="hirdet">Hirdetes Feladása</button>
            <p></p>
            <a href="hirdetesek.php"<button type="submit">Vissza a hirdetéseimhez</button></a>


        </form>
    </div>
</div>

</body>
</html>
