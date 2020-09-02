<?php

session_start();

if (empty($_SESSION['id'])) {
    header("Localhost: ../my-profile.php?error=onvalidEntry");
    exit();
}

if (isset($_POST['btnUpdateInterests'])) {

    //return true or false for successfull insert

    function insertInterests($connParam, $emailParam, $interestParam) {
        $stmt = mysqli_stmt_init($connParam);
        $sqlInterests = "SELECT * FROM tbl_interest ORDER BY name";
        $result = mysqli_query($connParam, $sqlInterests);
        $sqlSELECTid = "SELECT id,email FROM tbl_user WHERE email = ?";
        if (mysqli_num_rows($result) > 0) {
            $returnStatus = false;
            while ($row = mysqli_fetch_array($result)) {  //fetch rows from the db ; eg0. row[id] = 1 
                $check = "check" . $row ['id'];  //values to compair from the db ; eg0. $check = check1 ; eg0. $check = check2
                foreach ($interestParam as $key => $interest) {  //go through each check input till one matching the db is found ; eg0.$updateInterst = array , $key = [0] , $interest = check8 // eg1.$updateInterst = array , $key = [1] , $interest = check12 // eg2.$updateInterst = array , $key = [2] , $interest = check7 
                    if ($check === $interest) {  //eg0. false // false // false 
                        //find via email recently insert user, user id add interests
                        $sqlINSERTInterests = "INSERT INTO comp_tbl_user_tbl_interest ( email , interest_id ) VALUES (?,?)";

                        if (!mysqli_stmt_prepare($stmt, $sqlINSERTInterests)) {
                            $returnStatus = FALSE;
                        } else {
                            mysqli_stmt_bind_param($stmt, "si", $emailParam, $row['id']);
                            // echo $row['id'] . ' added to db <br>';
                            if (mysqli_stmt_execute($stmt)) {
                                $returnStatus = TRUE;
                            } else {
                                $returnStatus = FALSE;
                            }
                        }
                    }
                }
            }
            return $returnStatus;
        }
    }

}
?>

<?php

if (isset($_POST['btnUpdateDetails'])) {
    require './conn.inc.php';

//    validate all input
    $updateFirstName = filter_input(INPUT_POST, 'updateFirstname');
    $updateLastName = filter_input(INPUT_POST, 'updateLastname');
    $updateEmail = filter_input(INPUT_POST, 'updateEmail');
    $updateCountry = filter_input(INPUT_POST, 'updateCountry');
    $updateProvince = filter_input(INPUT_POST, 'updateProvince');
    $updateCity = filter_input(INPUT_POST, 'updateCity');

//$updateUsername = filter_input(INPUT_POST, 'inputUsername');  //ereg(“^[A-Za-z’ -]+$”,$name)
//    $updatePassword = filter_input(INPUT_POST, 'inputPassword');
//    $updateConfirmPassword = filter_input(INPUT_POST, 'inputConfirmPassword');
//    eg0. $updateInterests is array(4) { [0]=> string(6) "check8" [1]=> string(7) "check12" [2]=> string(6) "check7" }

    if (isset($_POST['check'])) {
        $updateInterest = filter_var_array($_POST['check']);
    }
//  print_r($_POST);
//Date validation 
    $progress = false; //initialize

    if (!isEmptyValidation($updateFirstName, $updateLastName, $updateEmail, $updateCountry, $updateProvince, $updateCity)) {

        if (isInvalidFormat($updateFirstName, $updateLastName, $updateEmail, $updateCountry, $updateProvince, $updateCity)) {
            header("Localhost: ../my-profile.php?error=formatvalidation");
            exit();
        } else { // when all input is valid 
            $sqlUpdateUser = "UPDATE tbl_user SET  first_name = ? , last_name = ? , email = ?, country = ? , province = ? ,  city = ? , update_date = ? WHERE id = ? ";  //'AND pwdUsers' pre-paired statement in db
            $stmt = mysqli_stmt_init($conn); //attempt to open connection 'initialize'
//prepaired statement
            if (!mysqli_stmt_prepare($stmt, $sqlUpdateUser)) {
                header("Localhost: ../my-profile.php?error=sqlError1"); //error=sqlError1
                exit();
            } else {

                $id = $_SESSION['id'];
//bind parameters to the placeholder
                $currentTime = date('Y-m-d H:i:s');
                mysqli_stmt_bind_param($stmt, "sssssssi", $updateFirstName, $updateLastName, $updateEmail, $updateCountry, $updateProvince, $updateCity, $currentTime, $id);

//run parameters in database
                if (mysqli_stmt_execute($stmt)) {
                    header("Localhost: ../my-profile.php?message=successUpdate"); //error=sqlError1
                    exit();
                } else {
                    header("Localhost: ../my-profile.php?message=failedUpdate"); //error=sqlError1
                    exit();
                }
            }
        }
    }
}

function isEmptyValidation($updateFirstNameParam, $updateLastNameParam, $updateEmailParam, $updateCountryParam, $updateProvinceParam, $updateCityParam) {
    if (empty($updateFirstNameParam) || empty($updateLastNameParam) || empty($updateEmailParam) || empty($updateCountryParam) || empty($updateProvinceParam) || empty($updateCityParam)) {
        return true;
    } else {
        return false;
    }
}

function isInvalidFormat($updateFirstNameParam, $updateLastNameParam, $updateEmailParam, $updateCountryParam, $updateProvinceParam, $updateCityParam) {
    $result = true;

    $errorsParam = '';
    if (!filter_var($updateEmailParam, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]$/i", $updateEmailParam)) {
        array_push($errorsParam, "emailInvalid");
//  echo 'e1';
        $result = true;
    } elseif (!preg_match("/^[A-Za-z' ,.-]{1,50}$/i", $updateFirstNameParam) || !preg_match("/^[A-Za-z' ,.-]{1,50}$/i", $updateLastNameParam)) {
        array_push($errorsParam, "invalidNames");
//  echo 'e6';
        $result = true;
    } elseif (!preg_match("/^[A-Za-z' -]{1,50}$/i", $updateCountryParam) || !preg_match("/^[A-Za-z' -]{1,50}$/i", $updateProvinceParam) || !preg_match("/^[A-Za-z' -]{1,50}$/i", $updateCityParam)) { //interests check
//        header("Localhost: ../my-profile.php?error=invalidLocationFormat");
//        exit();
        array_push($errorsParam, "invalidLocationFormat");
//   echo 'e7';
        $result = true;
    } else {
//    echo 'e8';

        $result = false;
    }
//   echo 'e9';
// echo "<br>$result";
    return $result; //$errorsParam remove the result true and return array for more accurate errors.
}
?>