<?php

include_once "connection.php";

$id = $_GET['munka_id'];
echo $id;

$conn = csatlakozas();
$sql = "BEGIN delete_munka(:id); END;";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":id", $id);

if(oci_execute($stmt)){
    echo '<script>alert("Sikeresen törölted a hirdetést!")</script>';
} else {
    echo '<script>alert("Valami hiba történt!")</script>';
}
header("Location: hirdetesek.php");
?>
