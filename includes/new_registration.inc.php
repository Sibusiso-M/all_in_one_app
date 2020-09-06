<?php

//ini_set(‘memory_limit’, ‘128M’);

require './conn.inc.php';
$sql = "SELECT unique_username FROM  tbl_user";
$existingUsernames = array();

$results = mysqli_query($conn, $sql);

if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($results)) {
        array_push($existingUsernames, $row['unique_username']);
    }
}

if (isset($_POST['suggestion'])) {
    $name = filter_input(INPUT_POST, 'suggestion');

    if (!empty($name)) {
        if (!preg_match("/^[A-Za-z0-9]{4,20}$/i", $name)) {
            echo '<p class="font-italic text-danger"><b>*must be 4-20 characters long containing letters or numbers.</b></p>';
        } else {

            if (in_array($name, $existingUsernames)) {
                echo '<p class="font-italic text-danger"><b>*username has already been taken.</b></p>';
            } else {
                echo '<p class="font-italic text-success"><b>*username is still available.</b></p>';
            }
        }
    }
}
?>

<?php

if (isset($_POST['password']) && !isset($_POST['cPassword'])) {
    $password = filter_input(INPUT_POST, 'password');

    if (!empty($password)) {
        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            echo '<p class="font-italic text-danger"><b>*Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</b></p>';
        } else {
            echo '<p class="font-italic text-success"><b>Strong password.</b><p>';
        }
    } else {
        echo 'Must contain at least 8 characters, 1 number, 1 special character.';
    }
}

if (isset($_POST['password']) || isset($_POST['cPassword'])) {

    $password = filter_input(INPUT_POST, 'password');
    $cPassword = filter_input(INPUT_POST, 'cPassword');

    if (!empty($password)) {

        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if ($uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8) {
            if (!empty($cPassword)) {
                if ($password == $cPassword) {
                    echo '<p class="font-italic text-success"><b>*Password match.</b></p>';
                } else {
                    echo '<p class="font-italic text-danger"><b>*Password must match.</b></p>';
                }
            }
        }
    }
}
?>

<?php

if (isset($_POST['btnCreateAccount'])) {
    require './conn.inc.php';

//    validate all input

    $newUsername = filter_input(INPUT_POST, 'inputUsername');  //ereg(“^[A-Za-z’ -]+$”,$name)
    $newFirstName = filter_input(INPUT_POST, 'inputFirstname');
    $newLastName = filter_input(INPUT_POST, 'inputLastname');
    $newEmail = filter_input(INPUT_POST, 'inputEmail');
    $newGender = filter_input(INPUT_POST, 'inputGender');
    $newDOB = filter_input(INPUT_POST, 'dateOfBirth');
    $newPassword = filter_input(INPUT_POST, 'inputPassword');
    $newConfirmPassword = filter_input(INPUT_POST, 'inputConfirmPassword');
    $newCountry = filter_input(INPUT_POST, 'inputCountry');
    $newProvince = filter_input(INPUT_POST, 'inputProvince');
    $newCity = filter_input(INPUT_POST, 'inputCity');


    // eg0. $newInterests is array(4) { [0]=> string(6) "check8" [1]=> string(7) "check12" [2]=> string(6) "check7" }
    if (isset($_POST['check'])) {
        $newInterest = filter_var_array($_POST['check']);
    }

    //  print_r($_POST);
    //Date validation 
    $dateTest = DateTime::createFromFormat('Y-m-d', $newDOB);
    $date_errors = DateTime::getLastErrors($dateTest);
    $progress = false; //initialize
    if (!isEmptyValidation($newUsername, $newFirstName, $newLastName, $newEmail, $newGender, $newDOB, $newPassword, $newConfirmPassword, $newCountry, $newProvince, $newCity)) {

        if (isInvalidFormat($newUsername, $newFirstName, $newLastName, $newEmail, $newGender, $newPassword, $newConfirmPassword, $newCountry, $newProvince, $newCity, $date_errors)) {
            header("Localhost: ../registration.php?error=formatvalidation");
            exit();
        } else { // when all input is valid 
            $sqlCredentials = "SELECT unique_username FROM tbl_user WHERE unique_username = ? OR email = ? ";  //'AND pwdUsers' pre-paired statement in db
            $stmt = mysqli_stmt_init($conn); //attempt to open connection 'initialize'
            //prepaired statement
            if (!mysqli_stmt_prepare($stmt, $sqlCredentials)) {
                header("Localhost: ../registration.php?error=sqlError1"); //error=sqlError1
                exit();
            } else {
                //bind parameters to the placeholder
                mysqli_stmt_bind_param($stmt, "ss", $newUsername, $newEmail);

                //run parameters in database
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $numResultNames = mysqli_stmt_num_rows($stmt);


                if ($numResultNames > 0) { //check for existing matching usernameUser /rows
                    //echo 'closed0';
                    //Close connection
                    mysqli_close($conn);

                    header("Localhost: ../registration.php?error=usernameUnavailable");
                    exit();
                } else { //build insert statements
                    $sqlINSERTUser = "INSERT INTO tbl_user ( unique_username, email, create_date, password, last_name, first_name, country , city , province , date_of_birth ) VALUES (?,?,?,?,?,?,?,?,?,?)";
                    $stmt = mysqli_stmt_init($conn); //attempt to open connection 'initialize'
//prepare the prepared statement
                    if (!mysqli_stmt_prepare($stmt, $sqlINSERTUser)) {
                        //  echo 'closed1';
                        //Close connection
                        mysqli_close($conn);

                        header("Localhost: ./registration.php?error=sqlError2"); //error=sqlError2
                        exit();
                    } else {
                        // echo 'within';
                        $todaysDate = date("Y-m-d");
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        //echo 'check0';

                        mysqli_stmt_bind_param($stmt, "ssssssssss", $newUsername, $newEmail, $todaysDate, $hashedPassword, $newLastName, $newFirstName, $newCountry, $newCity, $newProvince, $newDOB);

                        //run parameters in database

                        if (mysqli_stmt_execute($stmt)) {
                            $progress = true;

                            $sqlSELECTNewUser = "SELECT id FROM tbl_user WHERE email = '" . $newEmail . "'";
                            $results = mysqli_query($conn, $sqlSELECTNewUser);

                            if (mysqli_num_rows($results) > 0) {
                                while ($row = mysqli_fetch_assoc($results)) {
                                    $id = $row['id'];
                                    $activationcode = md5($newEmail . time());
                                    $sqlRegistration = "INSERT INTO tbl_user_registration (email, user_id, validated, activationcode) VALUES ('$newEmail',$id,0,'$activationcode') ;";
                                    mysqli_query($conn, $sqlRegistration);
                                }
                            }

                            $sqlProfilePicture = "INSERT INTO tbl_profile_pictures ( status, user_id) VALUES ('0', '$id')";
                            mysqli_query($conn, $sqlProfilePicture);
                            
                            if (!empty($newInterest)) {
                                // echo 'check3';
                                $progress = insertInterests($conn, $id, $newInterest);
                            }
                        }
                    }
                }
            }
        }
    }

//should new user insert well
if ($progress) {
        // echo 'closed2';
        if (mysqli_query($conn, $sqlRegistration)) {
            $to = $newEmail;
            $subject = "Email verification (project1.visualxprints.com)";
            $headers ='';
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:All In One App | Website <visualxprints.com>' . "\r\n";
            $ms ='';
            $ms.="<html>"
                    . "</body>"
                    . "<div>"
                    . "<div>Dear $newFirstName,</div>"
                    . "</br>"
                    . "</br>";
            $ms.="<div style='padding-top:8px;'>Please click The following link For verifying and activation of your account</div>
                    <div style='padding-top:10px;'><a href='https://www.project1.visualxprints.com/includes/email_verification.inc.php?code=$activationcode'  target='_blank'>Click Here</a></div>
                    <div style='padding-top:4px;'>Powered by <a href='visualxprints.com'>project1.visualxprints.com</a></div></div>"
                    . "</body>"
                    . "</html>";
            mail($to, $subject, $ms, $headers);
        } else {
            header("Localhost: ./registration.php?error=registration"); //error=sqlError2
        }
//Close connection
         
       // mysqli_close($conn);
        header("Localhost: ../index.php?message=success"); //error=sqlError2
        exit();
    } else {  // empty values $_POST[]
        //echo 'closed3';
//Close connection
        mysqli_close($conn);
        header("Localhost: ../registration.php?error=invalidMissingValues");
        exit();
    }
} else { // forced entry
    header("Localhost: ../registration.php?error=forcedEntry");
    exit();
}

//return true or false for successfull insert
function insertInterests($connParam, $idParam,$interestParam ) {

    $stmt = mysqli_stmt_init($connParam);
    $sqlInterests = "SELECT * FROM tbl_interest ORDER BY name";
    $result = mysqli_query($connParam, $sqlInterests); 

    if (mysqli_num_rows($result) > 0) {
        $returnStatus = false;
        while ($row = mysqli_fetch_array($result)) {  //fetch rows from the db ; eg0. row[id] = 1 
            $check = "check" . $row['id'];  //values to compair from the db ; eg0. $check = check1 ; eg0. $check = check2
           
            foreach ($interestParam as $key => $interest) {  //go through each check input till one matching the db is found ; eg0.$newInterst = array , $key = [0] , $interest = check8 // eg1.$newInterst = array , $key = [1] , $interest = check12 // eg2.$newInterst = array , $key = [2] , $interest = check7 
                if ($check === $interest) {  //eg0. false // false // false 
                    //find via email recently insert user, user id add interests
                    $sqlINSERTInterests = "INSERT INTO comp_tbl_user_tbl_interest ( user_id , interest_id ) VALUES (?,?)";

                    if (!mysqli_stmt_prepare($stmt, $sqlINSERTInterests)) {
                        $returnStatus = FALSE;
                    } else {
                        mysqli_stmt_bind_param($stmt, "ii", $idParam, $row['id']);
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

function isEmptyValidation($newUsernameParam, $newFirstNameParam, $newLastNameParam, $newEmailParam, $newGenderParam, $newDOBParam, $newPasswordParam, $newConfirmPasswordParam, $newCountryParam, $newProvinceParam, $newCityParam) {
    if (empty($newUsernameParam) || empty($newFirstNameParam) || empty($newLastNameParam) || empty($newEmailParam) || empty($newGenderParam) || empty($newDOBParam) || empty($newPasswordParam) || empty($newConfirmPasswordParam) || empty($newCountryParam) || empty($newProvinceParam) || empty($newCityParam)) {
        return true;
    } else {
        return false;
    }
}

function isInvalidFormat($newUsernameParam, $newFirstNameParam, $newLastNameParam, $newEmailParam, $newGenderParam, $newPasswordParam, $newConfirmPasswordParam, $newCountryParam, $newProvinceParam, $newCityParam, $date_errorsParam) {
    $result = true;

    if ($newPasswordParam === $newConfirmPasswordParam) {
        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $newPasswordParam);
        $lowercase = preg_match('@[a-z]@', $newPasswordParam);
        $number = preg_match('@[0-9]@', $newPasswordParam);
        $specialChars = preg_match('@[^\w]@', $newPasswordParam);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($newPasswordParam) < 7) {
            $passwordValidStatus = false;
        } else {
            $passwordValidStatus = true;
        }
    }

    if (!filter_var($newEmailParam, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]$/i", $newEmailParam)) {
        array_push($date_errorsParam, "emailInvalid");
        //  echo 'e1';
        $result = true;
    } elseif (!preg_match("/^[A-Za-z0-9]{1,20}$/i", $newUsernameParam)) {
        array_push($date_errorsParam, "usernameCharacters");
        // echo 'e2';
        $result = true;
    } elseif (!preg_match("/(Male|Female)/i", $newGenderParam)) {
        array_push($date_errorsParam, "emptyGender");
        // echo 'e3';
        $result = true;
    } elseif ($date_errorsParam['warning_count'] + $date_errorsParam['error_count'] > 0) {
        array_push($date_errorsParam, "invalidDate");
        // echo 'e4';
        $result = true;
    } elseif (!$passwordValidStatus) {
        array_push($date_errorsParam, "invalidPasswordMatch");
        // echo 'e5';
        $result = true;
    } elseif (!preg_match("/^[A-Za-z' ,.-]{1,50}$/i", $newFirstNameParam) || !preg_match("/^[A-Za-z' ,.-]{1,50}$/i", $newLastNameParam)) {
        array_push($date_errorsParam, "invalidNames");
        //  echo 'e6';
        $result = true;
    } elseif (!preg_match("/^[A-Za-z' -]{1,50}$/i", $newCountryParam) || !preg_match("/^[A-Za-z' -]{1,50}$/i", $newProvinceParam) || !preg_match("/^[A-Za-z' -]{1,50}$/i", $newCityParam)) { //interests check
//        header("Localhost: ../registration.php?error=invalidLocationFormat");
//        exit();
        array_push($date_errorsParam, "invalidLocationFormat");
        //   echo 'e7';
        $result = true;
    } else {
        //    echo 'e8';
        $result = false;
    }
    //   echo 'e9';
    // echo "<br>$result";
    return $result;
}
