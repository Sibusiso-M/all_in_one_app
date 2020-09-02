
<?php

if (isset($_POST['btnGuest-Sign-In'])) {
    include_once('./conn.inc.php');

    session_start();
    $_SESSION['id'] = 'Guest';
    header("Location: ../dashboard.php?login=success");
    exit();
} else {
    header("Location: ../sign-in.php");
    exit();
}