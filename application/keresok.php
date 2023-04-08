<?php
require_once("connection.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel=stylesheet type="text/css" href="css/style.css" />
</head>
<body>

<header>
    <header>
        <nav>
            <a  href="munkak.php.">Munkák</a>
            <a class="active" href="keresok.php">Keresők</a>
            <a href="cegek.php">Cégek</a>

        </nav>
    </header>

</header>

<?php


echo '<h2>A Kereso tábla adatai: </h2>';
echo '<table border="0">';
$con = csatlakozas();

//// -- lekerdezzuk a tabla tartalmat
$stid = oci_parse($con, 'SELECT * FROM KERESO');

oci_execute($stid);

//// -- eloszor csak az oszlopneveket kerem le
$nfields = oci_num_fields($stid);
echo '<tr class="tablehead">';
for ($i = 1; $i<=$nfields; $i++){
    $field = oci_field_name($stid, $i);
    echo '<th>' . $field . '</th>';
}
echo '</tr>';

//// -- ujra vegrehajtom a lekerdezest, es kiiratom a sorokat
    while ( ($valtozo = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) !=false) {
        echo '<tr>';
        foreach ($valtozo as $item) {
            echo '<td>' . $item . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';



oci_close($con);


?>
</body>
</html>
