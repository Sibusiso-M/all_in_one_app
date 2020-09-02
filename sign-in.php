<?php
include './header.php';
?>
<?php
//Content control 
if (!empty($_SESSION['id'])) {
    header("Location: ./index.php");
    exit();
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign In</title>
        <link rel="stylesheet" href="all_in_one_styles_app.css">
        <!-- Bootstrap -->

        <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap-reboot.css">


    </head>
    <body >

        <?php
        if (isset($_GET['emptyfield'])) {
            ?>
            <div class='text-center alert alert-danger alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Message!</strong> Text Fields can not be empty.
            </div>
            <?php
        }


        if (isset($_GET['emptyfield'])) {
            ?>
            <div class='text-center alert alert-danger alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Message!</strong> Text Fields can not be empty.
            </div>
            <?php
        }

        if (isset($_GET['error'])) {
            if ($_GET['error'] == "invalidemailorusernameId") {
                ?>

                <div class='text-center alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>Message!</strong> Invalid Login.
                </div>
                <?php
            }
        }

        if (isset($_GET['invalidemailorusernameformat'])) {
            ?>

            <div class='text-center alert alert-danger alert-dismissible fade show'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Message!</strong> Email format is not allowed.
            </div>
            <?php
        }

        if (isset($_GET['message'])) {

            if ($_GET['message'] == "success") {
                ?>
                <div class='text-center alert alert-success alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>Message! Congratulation</strong> Your account is now activated, you may sign-in.
                </div>
                <?php
            }

            if ($_GET['message'] == "active") {
                ?>         
                <div class='text-center alert alert-warning alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>Message!</strong> Your account is already activated, you may sign-in.
                </div>    
                <?php
            }

            if ($_GET['message'] == "activation") {
                ?>
                <div class='text-center alert alert-warning alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>Message!</strong> Your account is not verified yet. Please check your email.
                </div>
                <?php
            }

            if ($_GET['message'] == "wrongcode") {
                ?>
                <div class='text-center alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>Message!</strong>  Wrong activation code.
                </div>

                <?php
                
            }
                if ($_GET['message'] == "succesfulremove") {
                    ?>
                    <div class='text-center alert alert-success alert-dismissible fade show'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <strong>Message!</strong>  Your account has been removed from the system.
                    </div>

                    <?php
                }
            
        }
        ?>

        <form name="frmSignUp" action="./includes/sign_in.inc.php" method="post" class="form-signin">

            <div class="text-center"  >
                <img class="img-fluid text-center" src="media/grunge-hashtag-1.png" alt="hashtag logo" width="72" height="72">
            </div>
            <h1 class="h3 mb-3 font-weight-normal text-center">Sign in</h1>

            <div class="form-group">
                <label for="userEmail"  >Email address</label>
                <input type="email" id="userEmail" name="userEmail" class="form-control" placeholder="Email address" value="" required autofocus>
            </div>

            <div class="form-group">
                <label for="userPassword">Password</label>
                <input type="password" id="userPassword" name="userPassword" class="form-control " placeholder="Password" required >
            </div>

            <p>Not a member?<a class="text-center" href="registration.php" >Register</a></p>
            <input type="submit" name="btnSign-In"  class="btn btn-lg btn-primary btn-block" value="Sign In"/>
        </form>
        <h4 class="text-center">or</h4>
        <form name="frmSignUp" action="./includes/sign-in-as-guest.inc.php" method="post" class="form-signin">
            <input type="submit" name="btnGuest-Sign-In"  class="btn btn-lg btn-light btn-block" value="Sign In As Guest"/>
        </form>

        <?php require './footer.php'; ?>