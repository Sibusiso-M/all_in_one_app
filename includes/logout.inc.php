<?php
    session_start();
 
    $_SESSION['id'] = "";
    session_unset();
    session_destroy();
    header("Location: ../index.php?message=logutsuccess");
    exit();
 
    