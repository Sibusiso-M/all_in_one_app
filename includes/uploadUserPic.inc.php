<?php

session_start();
?>
<?php

if (isset($_POST['btnSubmitPicture'])) {

    $file = $_FILES['profilePicture'];
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];


    $fileExt = explode('.', $fileName); //returns array
    $fileActualExt = strtolower(end($fileExt)); // last value of array

    $allowed = array('jpg', 'jpeg', 'png', 'jfif');  //allowed extentions
    if (empty($fileName)) {
        header("Location: ../my-profile.php?emptyfile");
        exit();
    } else {

        if (!in_array($fileActualExt, $allowed)) {
            header("Location: ../my-profile.php?uploadinvalidformat");
            exit();
        } else {
            if (!$fileError === 0) {
                header("Location: ../my-profile.php?uploadeerror");
                exit();
            } else {
                if (!$fileSize >= 5242880) { // 5MB
                    header("Location: ../my-profile.php?sizelimit");
                    exit();
                } else {
                    $id = $_SESSION['id'];

                    // remove previous pic from memory 
                    $fileOldName = '../uploads/profile' . $id . '*';

                    if (!empty(glob($fileOldName))) {
                        $fileInfo = glob($fileOldName);
                        unlink($fileInfo[0]);
                    }


                    $fileName = 'profile' . $id . "." . $fileActualExt;
                    $fileDestination = '../uploads/' . $fileName;

                    move_uploaded_file($fileTmpName, $fileDestination);
                    $sqlUpdate = "UPDATE tbl_profile_pictures SET status = 1  WHERE user_id = " . $id;
                    include './conn.inc.php';
                    mysqli_query($conn, $sqlUpdate);

                    header("Location: ../my-profile.php?uploadsuccess");
                    exit();
                }
            }
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}