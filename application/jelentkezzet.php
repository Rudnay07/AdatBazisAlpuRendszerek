<?php
require_once("connection.php");
session_start();

?>


<?php
$conn = csatlakozas();

$email = $_SESSION['loguser'];
echo $email;
$sql = "SELECT * FROM KERESO WHERE email=:email";
$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':email', $email);

if (oci_execute($stid)) {
    $res = oci_fetch_array($stid, OCI_ASSOC);
    if ($res) {
        $id = $res['FELHASZNALOID'];
    }
}
echo $id;
oci_free_statement($stid);

$munka_id = $_GET["munka_id"];
echo $munka_id;


// Prepare statement az SQL Injection támadások elkerülésér
    $stmt = oci_parse($conn, "INSERT INTO JELENTKEZETT (jelentkezettID,datum, FelhasznaloID, MunkaID) VALUES (jelentkezett_seq.nextval,SYSDATE, $id, $munka_id)");
    echo 'itt vagyunk';
    if (oci_execute($stmt)) {
        echo'2';
        ?> <script>alert("Sikeresen jelentkeztél")
            document.location.replace('profil.php');</script><?php
    } else {
        ?> <script> alert('Valami hiba törént ')</script><?php
    }
oci_close($conn);
?>



