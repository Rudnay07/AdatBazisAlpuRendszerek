<?php
require_once("connection.php");
session_start();
$conn = csatlakozas();
$message = "";

if (isset($_POST['login'])) {
    // Felhasználói adatok ellenőrzése
    $email = $_POST['email'];
    $password = $_POST['password'];
    // SQL lekérdezés a felhasználó ellenőrzésére
    $query = "SELECT * FROM Hirdeto WHERE email = '$email' AND jelszo = '$password'";
    $result = oci_parse($conn, $query);
    oci_execute($result);
    $row = oci_fetch_array($result, OCI_ASSOC);

    // Ha a lekérdezés sikeres és találtunk felhasználót
    if ($row) {
        // Bejelentkezés sikeres, továbbítás a főoldalra
        $_SESSION["loghirdeto"] = $email;

        header("Location: Main.php");
    } else {
        // Hibaüzenet
        $message = "Hibás felhasználónév vagy jelszó";
    }


}

if (isset($_POST['register'])) {
    // Felhasználói adatok ellenőrzése
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $ceg = $_POST['ceg'];



    $sql = "SELECT hirdeto_seq.NEXTVAL FROM dual";
    $stid = oci_parse($conn, $sql);
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC);
    $hirdeto_id = $row['NEXTVAL'];

    // Prepare statement az SQL Injection támadások elkerülésér
    $stmt = oci_parse($conn, "INSERT INTO Hirdeto (FelhasznaloID, Nev, Email, Jelszo, HirdetoID, CegID) VALUES (:felhasznalo_id, :name, :email, :password, :hirdeto_id, :ceg)");
    oci_bind_by_name($stmt, ":felhasznalo_id", $hirdeto_id);
    oci_bind_by_name($stmt, ":name", $name);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":password", $password);
    oci_bind_by_name($stmt, ":hirdeto_id", $hirdeto_id);
    if($ceg === "null"){
        $ceg = null;
        oci_bind_by_name($stmt, ":ceg", $ceg);
    } else {
        oci_bind_by_name($stmt, ":ceg", $ceg);
    }
    // Lekérdezés futtatása
    if (oci_execute($stmt)) {
        // Sikeres regisztráció, továbbítás a bejelentkező oldalra
        header("Location: regHirdetokent.php");
    } else {
        $message = "Valami hiba történt a regisztárció során";
    }
}


?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>

<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form method="POST" autocomplete="off">
            <h1>Regisztráció</h1>
            <input type="text" placeholder="Név" name="name"/>
            <input type="email" placeholder="Email" name="email"/>
            <input type="password" placeholder="Jelszó" name="password"/>
            <select id="cars" name="ceg">
                <?php

                $conn = csatlakozas();
                $query = "SELECT cegid,cegnev FROM CEG";
                $stid = oci_parse($conn, $query);

                oci_execute($stid);
                while (($valtozo = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
                    echo '<option value="'. $valtozo['CEGID'] .'">'. $valtozo['CEGNEV'] .'</option>';
                }

                ?>
                <option value="null">Nem szerepel a felsoroltak között.</option>
            </select>
            <button type="submit" name="register">Regisztráció</button>

        </form>
    </div>
    <div class="form-container sign-in-container">
        <form method="POST" autocomplete="off">
            <h1>Bejelentkezés</h1>
            <?php if ($message != "") { ?>
                <p><?php echo $message; ?></p>
            <?php } ?>
            <input type="email" placeholder="Email" name="email"/>
            <input type="password" placeholder="Jelszó" name="password"/>

            <button type="submit" name="login">Bejelentkezés</button>
            <p></p>
            <a href="bejelentkezes.php"<button type="submit">Bejelentkezés, mint Kereső</button></a>


        </form>
    </div>


    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Üdv újra!</h1>
                <p>Ha van profilja, akkor jelentkezzen be</p>
                <button class="ghost" id="signIn">Van profilom</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Üdv a weblapon</h1>
                <p>Kérem adja meg az adatait.</p>
                <button class="ghost" id="signUp">Regisztráció</button>
                <p> </p>
                <a href="bejelentkezes.php"><button class="ghost">Regisztáció Kersőként </button> </a>
            </div>
        </div>
    </div>
</div>

<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
</script>

</body>
</html>
