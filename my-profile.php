
<?php
include_once './header.php';
?>


<?php
//Content control 
if (empty($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
?>

<?php

function getProfilePicture() {

    $profilePicture = "uploads/default-user.png";  // default picture

    if (empty($_SESSION['id'])) {
        header("Location: index.php?error=nosession");
    } elseif (!empty($_SESSION['id']) && $_SESSION['id'] == 'Guest') {

        $id = $_SESSION['id'];

        $fileName = 'uploads/profile' . $id . '*';
        $fileInfo = glob($fileName);  // find in directory

        $fileExt = explode('.', $fileInfo[0]);
        $fileActualExt = $fileExt[1];
        $profilePicture = 'uploads/profile' . $id . '.' . $fileActualExt . '?' . mt_rand();
    } else {
        include 'includes/conn.inc.php';
        $id = $_SESSION['id'];
        $sqlCheckPicture = "SELECT * FROM tbl_profile_pictures WHERE user_id = " . $id;
        $resultss = mysqli_query($conn, $sqlCheckPicture);


        if (mysqli_num_rows($resultss) > 0) {
            while ($row = mysqli_fetch_assoc($resultss)) {
                $status = $row['status'];
                if ($status == 1) {

                    $fileName = 'uploads/profile' . $id . '*';
                    $fileInfo = glob($fileName);  // find in directory

                    $fileExt = explode('.', $fileInfo[0]);
                    $fileActualExt = $fileExt[1];
                    $profilePicture = 'uploads/profile' . $id . '.' . $fileActualExt . '?' . mt_rand();
                }
            }
        }
    }
    return $profilePicture;
}
?>


<div class="container text-center">

    <h3 class=" text-center">User Profile</h3>
    <?php
    if (isset($_GET['sizelimit'])) {
        ?>
        <div class='text-center alert alert-danger alert-dismissible fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Message!</strong> File size larger the allowed limit of <strong>5MB</strong>
        </div>
        <?php
    }

    if (isset($_GET['uploadinvalidformat'])) {
        ?>

        <div class='text-center alert alert-danger alert-dismissible fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Message!</strong> There was an file type problem, only (jpg, jpeg, png, jfif) format allowed.
        </div>
        <?php
    }

    if (isset($_GET['uploadeerror'])) {
        ?>

        <div class='text-center alert alert-danger alert-dismissible fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Message!</strong> There was a problem uploading your file. Please try again.
        </div>
        <?php
    }

    if (isset($_GET['uploadsuccess'])) {
        ?>
        <div class='text-center alert alert-success alert-dismissible fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Message!</strong> Upload was successful.
        </div>

        <?php
    }

    if (isset($_GET['emptyfile'])) {
        ?>
        <div class='text-center alert alert-danger alert-dismissible fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Message!</strong> No file chosen.
        </div>
        <?php
    }

    if (isset($_GET['removesuccess'])) {
        ?> 

        <div class='text-center alert alert-info alert-dismissible fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Message!</strong> Profile picture has been removed.
        </div>
        <?php
    }
    ?>
    <div class="row">
        <div class="col">
            <!-- Profile and starts -->
            <div class="img-fluid text-center m-2">
                <img src= '<?php echo getProfilePicture(); ?>' class="rounded-circle" alt="Profile Picture" width="100" height="100">
            </div>
            <?php
            if ($_SESSION['id'] == 'Guest') {
                
            } else {
                include 'includes/conn.inc.php';
                $id = $_SESSION['id'];

                $sqlStatus = "SELECT status FROM tbl_profile_pictures WHERE user_id = " . $id;
                $result = mysqli_query($conn, $sqlStatus);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $status = $row['status'];
                    }
                }
                if (!$status == 0) {
                    ?>
                    <div class= ''>
                        <form action='includes/removePic.inc.php' method='POST'>
                            <button class='btn btn-link text-secondary' type='submit' name='btnSubmitRemovePic'>Remove Picture</button>
                        </form>
                    </div>
                    <?php
                }
            }
            if ($_SESSION['id'] == 'Guest') {
                
            } else {
                ?>
                <form action="includes/uploadUserPic.inc.php" method="POST" enctype="multipart/form-data">
                    <input  type="file" name="profilePicture"  >
                    <br>
                    <button class="btn btn-info" type="submit" name="btnSubmitPicture">Upload</button>
                </form>

                <?php
            }
            ?>


            <hr class="hr">

            <h2 class="h2">Interests</h2>

            <form action="includes/updateProfile.inc.php" method="POST" enctype="multipart/form-data">
                <br>
                <button class="btn btn-info" type="submit" name="btnUpdateInterests">Save Interests</button>
            </form>
        </div>


        <?php
        if ($_SESSION['id'] == 'Guest') {
//Add a temp self destructing and reseting Guest profile to default values. To implement CRUD 

            echo '';
        } else {
            ?> 

            <div class="col border">

                <?php
                $sqlUserDetails = "SELECT unique_username, email, first_name, last_name, date_of_birth, country, province, city FROM tbl_user WHERE id = " . $id;
                $results = mysqli_query($conn, $sqlUserDetails);

                $username = '';
                $email = '';
                $first_name = '';
                $last_name = '';
                $date_of_birth = '';
                $country = '';
                $province = '';
                $city = '';

                if (mysqli_num_rows($results) > 0) {
                    while ($row = mysqli_fetch_assoc($results)) {
                        $username = $row['unique_username'];
                        $email = $row['email'];
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        $date_of_birth = $row['date_of_birth'];
                        $country = $row['country'];
                        $province = $row['province'];
                        $city = $row['city'];
                    }
                } else {
                    echo '0 Results';
                }

                if (!isset($_POST['btnSubmitEdit'])) {
                    ?>
                    <ul class='list-group'>
                        <li class='list-group-item'>Email
                            <input type='text' disabled placeholder= "<?php echo $email ?> ">
                        </li>
                        <li class='list-group-item'>First Name
                            <input type='text' disabled placeholder= "<?php echo $first_name ?> " >
                        </li>
                        <li class='list-group-item'>Last Name
                            <input type='text' disabled placeholder= "<?php echo $last_name ?> " >
                        </li>
                        <li class='list-group-item'>Date Of Birth
                            <input type='text' disabled placeholder= "<?php echo $date_of_birth ?> ">
                        </li>
                        <li class='list-group-item'>Country
                            <input type='text' disabled placeholder= "<?php echo $country ?> " >
                        </li>
                        <li class='list-group-item'>Province
                            <input type='text' disabled placeholder= "<?php echo $province ?> " >
                        </li>
                        <li class='list-group-item'>City
                            <input type='text' disabled placeholder= "<?php echo $city ?> " >
                        </li>
                    </ul>
                    <form action='my-profile.php' method='POST'>
                        <button class='btn btn-link' type='submit' name='btnSubmitEdit'>Edit</button>
                    </form>
                </div>
                <?php
            } else {
                ?>
                <form action='includes/updateProfile.inc.php' method='POST'>
                    <ul class='list-group'>
                        <li class='list-group-item'>Email
                            <input type='text' required class='form-control' name='updateEmail' id='updateEmail' maxlength='50' value= "<?php $email ?> ">
                        </li>
                        <li class='list-group-item'>First Name
                            <input type='text' required class='form-control' name='updateFirstname' id='updateFirstname' maxlength='50' value= "<?php echo $first_name ?> " >
                        </li>
                        <li class='list-group-item'>Last Name
                            <input type='text' required class='form-control' name='updateLastname' id='updateLastname' maxlength='50' value= "<?php echo $last_name ?> ">
                        </li>
                        <li class='list-group-item'>Date Of Birth
                            <input type='text'  disabled class='form-control text-center' name='updateDateOfBirth' id='updateDateOfBirth' placeholder= "<?php echo $date_of_birth ?> " >
                        </li>
                        <li class='list-group-item'>Country
                            <input type='text' required class='form-control' name='updateCountry' id='updateCountry' maxlength='50' value= "<?php echo $country ?> " >
                        </li>
                        <li class='list-group-item'>Province
                            <input type='text' required class='form-control' name='updateProvince' id='updateProvince' maxlength='50' value= "<?php echo $province ?> ">
                        </li>
                        <li class='list-group-item'>City
                            <input type='text' required class='form-control' name='updateCity' id='updateCity' maxlength='50' value= "<?php echo $city ?> " >
                        </li>
                    </ul>
                    <button class='btn btn-success' type='submit' name='btnUpdateDetails'>Save</button>
                </form>
                <form action='my-profile.php' method='POST'>
                    <button class='btn btn-danger' type='submit' name='btnSubmitCancel'>Cancel</button>
                </form>
            </div>

            <?php
        }
    }
    ?>

</div>


<hr class="hr">
<div class="list-group">
    <ul class="nav flex-column nav-pills">
        <li class="nav-item">
            <a  class="nav-link" href="#">Screen Time Today (50 minutes)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Screen Time Total (5h 30 minutes)</a>
        </li>
        <li hidden class="nav-item">
            <a class="nav-link" href="#">Print My Progress (PDF)</a> <p hidden="">(share progress with employees, friends)</p>
        </li>
        <li>
            <form>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="daily_reminder">
                    <label class="custom-control-label" for="daily_reminder">Notify me daily</label>
                </div>
            </form>  
        </li>
    </ul>

    <?php
    if ($_SESSION['id'] !== 'Guest') {
        ?>
        <form action="includes/delete_user_account.inc.php" method="POST">
            <input type="submit" class = "btn btn-danger" name="btnDeleteAccount" value ="Delete My Account">
        </form>
        <?php
    }
    ?>


</div>

<?php
include_once './footer.php';
?>