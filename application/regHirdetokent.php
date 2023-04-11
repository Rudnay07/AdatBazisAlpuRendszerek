<?php
require_once("connection.php");
session_start();
$conn = csatlakozas();
$message = "";



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
            <a href="regHirdetokent.php"<button type="submit">Bejelentkezés, mint Hirdető</button></a>


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
                <a href="regHirdetokent.php"><button class="ghost">Regisztáció hirdetőként </button> </a>
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
