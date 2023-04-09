<?php
session_start();
unset($_SESSION['email']);
session_destroy();
echo "<script>;
        alert('Logout was successful!')
        document.location.replace('bejelentkezes.php');
        </script>";

?>


