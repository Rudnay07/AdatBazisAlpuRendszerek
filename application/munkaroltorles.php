<?php

include_once "connection.php";

$id = $_GET['jelentkezettid'];

$conn = csatlakozas();
$sql = "BEGIN delete_jelentkezett(:jelentkezett_id); END;";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":jelentkezett_id", $id);


if(oci_execute($stmt)){
    echo '<script>alert("Sikeresen törölted a jelentkezésed!!")</script>';
    header("Location: Idejelentkezett.php");
} else {
    echo '<script>alert("Valami hiba történt!")</script>';
    header("Location: Idejelentkezett.php");
}
?>