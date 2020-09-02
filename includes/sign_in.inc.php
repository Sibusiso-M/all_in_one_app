

<?php

if (isset($_POST['btnSign-In'])) {
    include_once('./conn.inc.php');
    $userEmail = filter_input(INPUT_POST, 'userEmail');
    $userPassword = filter_input(INPUT_POST, 'userPassword');
    //   $username = filter_input(INPUT_POST, 'username');

    if (empty($userEmail) || empty($userPassword)) {

        header("Location: ../sign-in.php?error=emptyfields");
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9+@. ]*$/", $userEmail)) {
        header("Location: ../signin.php?error=invalidemailorusernameformat");
        exit();
    } else {

        $sql = "SELECT * FROM tbl_user WHERE email = ?"; //prepaired statment check for username or email on DB but no results return
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo 'closed0';
            //Close connection
            mysqli_close($conn);

            header("Location: ../sign-in.php");
            exit();
        } else {

            mysqli_stmt_bind_param($stmt, "s", $userEmail);
            mysqli_stmt_execute($stmt);
            $results = mysqli_stmt_get_result($stmt); //raw data
            // $resultCheck = mysqli_stmt_num_rows($stmt);

            if ($row = mysqli_fetch_assoc($results)) {

                if ($row['validated'] == 1) {
                    $passwordCheck = password_verify($userPassword, $row['password']); // hashed

                    if ($passwordCheck == false) {
//                    echo 'closed1';
                        //Close connection
                        mysqli_close($conn);
                        header("Location: ../sign-in.php?error=invalidemailorusernameId");
                        exit();
                    } elseif ($passwordCheck == true) {
                        session_start();
                        $_SESSION['id'] = $row['id'];
                        header("Location: ../dashboard.php?login=success");
                        exit();
                    }
                } else {
                    header("Location: ../sign-in.php?message=activation");
                    exit();
                }
            } else {

                echo 'closed';
                //Close connection
                mysqli_close($conn);

                header("Location: ../sign-in.php?error=invalidemailorusernameId");
                exit();
            }
        }
    }
} else {
    header("Location: ../sign-in.php");
    exit();
}

