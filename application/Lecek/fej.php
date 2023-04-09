<?php
require_once("connection.php");
session_start();
$conn = csatlakozas();
$email = $_SESSION['loguser'];

$sql = "SELECT * FROM KERESO WHERE email=:email";
$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':email', $email);

if (oci_execute($stid)) {
    $res = oci_fetch_array($stid, OCI_ASSOC);
    if ($res) {
        $name = $res['NEV'];
    }}
oci_free_statement($stid);
oci_close($conn);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Cégek </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/lec.css">


</head>
<div class="menu-container">

    <input type="checkbox" id="openmenu" class="hamburger-checkbox">

    <div class="hamburger-icon">
        <label for="openmenu" id="hamburger-label">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>

    <div class="menu-pane">

        <nav>
            <ul class="menu-links">
                <li><a href="munkak.php">Munkák</a></li>
            </ul>
            <ul class="menu-links">
                <li><a href="cegek.php">Cégek</a></li>
            </ul>
            <ul class="menu-links">
                <li><a href="###">Profilom</a></li>
            </ul>
            <ul class="menu-links">
                <li><a href="Kijelentkezes.php"> Kijelentkezes </a></li>
            </ul>
            </ul>


        </nav>
    </div>
    <div class="body-text">
        <?php
        $ki = "Üdvözlöm " . $name . "!";
        if (!empty($name)) {
            echo '<h1>' .$ki . '</h1>';
        }
        ?>

        <h2></h2>
        <p></p>
    </div>
</div>
