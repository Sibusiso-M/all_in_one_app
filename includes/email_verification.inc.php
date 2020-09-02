<?php
// $_GET['code'] = "6d63dcd953156aea4bf6383a50c7abba";

if (isset($_GET['code'])) {

    include './conn.inc.php';
    $code = $_GET['code'];
    $stmt = mysqli_stmt_init($conn);
    $sqlRegistrationCheck = "SELECT * FROM tbl_user_registration WHERE activationcode = ?";

    if (mysqli_stmt_prepare($stmt, $sqlRegistrationCheck)) {

        mysqli_stmt_bind_param($stmt, "s", $code);
        mysqli_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num = mysqli_stmt_num_rows($stmt);

        if ($num > 0) {
            $st = 0;
            $sqlAccRegistration = "SELECT user_id FROM tbl_user_registration WHERE activationcode = '$code' AND validated = $st";
            $results = mysqli_query($conn, $sqlAccRegistration);

            if (mysqli_num_rows($results) > 0) {
                while ($row = mysqli_fetch_assoc($results)) {
                    
                    $sqlActivateUser =   "UPDATE tbl_user SET validated = " . 1 . " WHERE id = ".$row['user_id'];
                    mysqli_query($conn, $sqlActivateUser);
                    
                    $sqlUPDATERegistor = "UPDATE tbl_user_registration SET validated = " . 1 . " WHERE user_id = " . $row['user_id']  ;
                    mysqli_query($conn, $sqlUPDATERegistor);
                    
                    header("Location: ../sign-in.php?message=success");
                }
            } else {
                header("Location: ../sign-in.php?message=active");
            }
        } else {
            header("Location: ../sign-in.php?message=wrongcode");
        }
    }
}