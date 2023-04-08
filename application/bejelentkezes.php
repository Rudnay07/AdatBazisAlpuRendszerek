<?php
require_once("connection.php");
session_start();
$conn = csatlakozas();
$message = "";

// Ha a bejelentkezés gombra kattintottak
if (isset($_POST['login'])) {
    // Felhasználói adatok ellenőrzése
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL lekérdezés a felhasználó ellenőrzésére
    $query = "SELECT * FROM KERESO WHERE email = '$email' AND jelszo = '$password'";

    // Lekérdezés futtatása
    $result = oci_parse($conn, $query);
    oci_execute($result);

    // Ha a lekérdezés sikeres és találtunk felhasználót
    if (oci_fetch($result)) {
        // Bejelentkezés sikeres, továbbítás a főoldalra
        header("Location: Main.php");
    } else {
        // Hibaüzenet
        $message = "Hibás felhasználónév vagy jelszó";
    }
}
// Ha a regisztráció gombra kattintottak
if (isset($_POST['register'])) {
// Felhasználói adatok ellenőrzése
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $birth_date = $_POST['szüliidó'];
    $education = $_POST['vegzettseg'];

// Prepare statement az SQL Injection támadások elkerülésér
    $stmt = oci_parse($conn, "INSERT INTO KERESO (FelhasznaloID, Nev, Email, Jelszo, SzuletesiIdo, Vegzettseg) VALUES (kereso_seq.nextval, :name, :email, :password, TO_DATE(:birth_date, 'YYYY-MM-DD'), :education)");
    oci_bind_by_name($stmt, ":name", $name);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":password", $password);
    oci_bind_by_name($stmt, ":birth_date", $birth_date);
    oci_bind_by_name($stmt, ":education", $education);



// Lekérdezés futtatása
    if (oci_execute($stmt)) {
// Sikeres regisztráció, továbbítás a bejelentkező oldalra
        header("Location:../Main.php");
    } else {
        $message="Valami hiba történt a regisztárció során";
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
            <input type="date" placeholder="Születési Idő" name="szüliidó"/>
            <input type="text" placeholder="Végzetség" name="vegzettseg"/>


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
