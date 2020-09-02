<?php

session_start();

if (isset($_POST['btnSubmitRemovePic'])) {
    
    $id = $_SESSION['id'];

    $fileName = '../uploads/profile' . $id . '*';
    $fileInfo = glob($fileName);
    
    if (!unlink($fileInfo[0])) {
        header("Location: ../my-profile.php?removefail");
        exit();
    } else {
        $sql = "UPDATE tbl_profile_pictures SET status = 0 WHERE user_id =".$id;
        include_once 'conn.inc.php';
        mysqli_query($conn, $sql);
        header("Location: ../my-profile.php?removesuccess");
        exit();
    }
}