<?php
session_start();
//
if (isset($_POST['btnDeleteAccount']) ) {
//remove from db
//check pro pic status, remove pro pic save space
    $id = $_SESSION['id'];
    
    
    include('./conn.inc.php');
    $sql = "DELETE FROM tbl_user WHERE id = $id ;"; //prepaired statment check for username or email on DB but no results return

    if (!mysqli_query($conn, $sql)) {
//Log if query fails
        $txt = "Error deleting record: 1 " . mysqli_error($conn);
        systemLog($txt);
   //     exit();
    } else {

// delete user records from all tables  

        $sql = "SELECT * FROM  tbl_profile_pictures WHERE user_id = $id ;";

        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {  //change to if

            if ($row['status'] == 1) {
//remove pp from files
                $fileName = '../uploads/profile' . $id . '*';
                $fileInfo = glob($fileName);

                if (!unlink($fileInfo[0])) {
//log if remove fails
                    $txt = "Error deleting picture: 2" . mysqli_error($conn) ;
                    systemLog($txt);
                }
            }
            $sql = "DELETE FROM tbl_profile_pictures WHERE user_id =  $id ;";
            if (!mysqli_query($conn, $sql)) {
                //Log error

                $txt = "Error deleting record: 3" . mysqli_error($conn);
                systemLog($txt);
            }
        }

        $sql = "DELETE FROM tbl_user_registration WHERE user_id = $id ;" ;
        if (!mysqli_query($conn, $sql)) {
            //Log error
            $txt = "Error deleting record: 4" . mysqli_error($conn) ;
            systemLog($txt);
        }

        $sql = "DELETE FROM comp_tbl_user_tbl_interest WHERE user_id = $id ;"  ;
        if (!mysqli_query($conn, $sql)) {
            //Log error
            $txt = "Error deleting record: 5" . mysqli_error($conn);
            systemLog($txt);
        }

        $_SESSION['id'] = "";
        session_unset();
        session_destroy();
        header("Location: ../sign-in.php?message=succesfulremove");
        exit();
    }
} else {
    header("Location: ../sign-in.php");
    exit();
}

//Log system errors to file 
function systemLog($errorParam) {
    $timeLog = date('d-m-Y H:i:s');
    $errorParam =  $timeLog. $errorParam . " \n";
    $logFile = fopen("system_log.txt", "a");
    fwrite($logFile, $errorParam);
    fclose($logFile);
}
