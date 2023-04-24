<?php

include_once "connection.php";

$id = $_GET['jelentkezettid'];

$conn = csatlakozas();
$sql = "DELETE FROM JELENTKEZETT WHERE MUNKAID=:id";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, "id", $id);

if(oci_execute($stmt)){
    echo '<script>alert("Sikeresen törölted a jelentkezésed!!")</script>';
    header("Location: Idejelentkezett.php");
} else {
    echo '<script>alert("Valami hiba történt!")</script>';
    header("Location: Idejelentkezett.php");
}
?>