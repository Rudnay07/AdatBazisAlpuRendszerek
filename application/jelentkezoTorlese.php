<?php

include_once "connection.php";

$id = $_GET['jelentkezoid'];

$conn = csatlakozas();
$sql = "DELETE FROM JELENTKEZETT WHERE JELENTKEZETTID=:id";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, "id", $id);

if(oci_execute($stmt)){
    echo '<script>alert("Sikeresen törölted a jelentkezőt!!")</script>';
    header("Location: hirdetesek.php");
} else {
    echo '<script>alert("Valami hiba történt!")</script>';
    header("Location: hirdetesek.php");
}
?>