<?php

include_once "connection.php";

$id = $_GET['munka_id'];

$conn = csatlakozas();
$sql = "DELETE FROM MUNKA WHERE MUNKAID=:id";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, "id", $id);

if(oci_execute($stmt)){
    echo '<script>alert("Sikeresen törölted a hirdetést!")</script>';
    header("Location: hirdetesek.php");
} else {
    echo '<script>alert("Valami hiba történt!")</script>';
    header("Location: hirdetesek.php");
}
?>
