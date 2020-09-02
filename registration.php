
<?php
require './header.php';
?>

<?php
if (!empty($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
?>

<?php
require_once './includes/conn.inc.php';
?>

<script defer>
    $(document).ready(function () {

        $("input").keyup(function () {
            var name = $("#inputUsername").val();

            $.post("includes/new_registration.inc.php", {suggestion: name},
            function (data, status) {
                $("#usernameSuggestion").html(data);
            });
        });
    });
</script>


<script defer>
    $(document).ready(function () {

        $("#inputPassword").keyup(function () {
            var password = $("#inputPassword").val();

            $.post("includes/new_registration.inc.php", {password: password},
            function (data, status) {
                $("#passwordHelpInline").html(data);
            });
        });


        $("#inputConfirmPassword").keyup(function () {

            var password = $("#inputPassword").val();
            var cPassword = $("#inputConfirmPassword").val();

            $.post("includes/new_registration.inc.php", {password: password, cPassword: cPassword},
            function (data, status) {
                $("#cPasswordHelpInline").html(data);
            });
        });

    });
</script>


<!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

<!-- Bootstrap Date-Picker Plugin -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<div class="container">
    <h1 class="h1 text-center">Registration</h1>        
    
    
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == "formatvalidation") {
            echo "<div class='text-center alert alert-danger alert-dismissible fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Message!</strong> Some fields are in a invalid format.
        </div>";
        }

        if ($_GET['error'] == "sqlError1") {
            echo "<div class='text-center alert alert-danger alert-dismissible fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Message!</strong> There was an error, please contact administrator.
        </div>";
        }

        if ($_GET['error'] == 'usernameUnavailable') {
            echo "<div class='text-center alert alert-danger alert-dismissible fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Message!</strong> Chosen username has been taken, please try another one.
        </div>";
        }

        if ($_GET['error'] == 'invalidMissingValues') {
            echo "<div class='text-center alert alert-danger alert-dismissible fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Message!</strong> Invalid or missing values.
        </div>";
        }
    }
    ?>

    <form name="frmRegistration" action="includes/new_registration.inc.php"  method="post"  >
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="inputFirstname">First Name</label>
                <input type="text" class="form-control" name="inputFirstname" id="inputFirstname" placeholder="Firstname" maxlength="50" required autofocus>
                <div class="invalid-feedback">
                    Please provide your First Name
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="inputLastname">Last Name</label>
                <input name="inputLastname" type="text" class="form-control" id="inputLastname" placeholder="Lastname" maxlength="50" required>
                <div class="invalid-feedback">
                    Please provide your Last Name
                </div>
            </div>

            <div class="col-md-4">
                <label for="inputUsername">Username</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="atSignPrepend" >@</span>
                    </div>
                    <input name="inputUsername" type="text" class="form-control" id="inputUsername" placeholder="Username" aria-descibedby="atSignPrepend" required maxlength="20">

                </div>


                <small class="text-muted">
                    Must be 4-20 characters long containing letters or numbers.
                </small>

                <div id="usernameSuggestion"></div>

            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <div class="input-group"> 
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input name="inputEmail" type="email" id="inputEmail" class="form-control m-1" placeholder="Email address" required >
                    <div class="invalid-feedback">
                        Please provide your valid Email
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputGender">Gender</label>
                <select name="inputGender" id="inputGender" class="form-control" >
                    <option selected >Choose...</option>
                    <option>Male</option>
                    <option>Female</option>    
                </select>
            </div>

            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="bootstrap-iso">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group"> <!-- Date input -->
                                <label class="control-label" for="dateOfBirth">Date of Birth</label>
                                <input class="form-control" id="dateOfBirth" name="dateOfBirth" type="date" placeholder="yyyy-mm-dd" maxlength="10" required /> <!-- Input Validation -->
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div> 

        <div class="form-row">
            <div class="form-group col-md-6 ">
                <label for="inputPassword">Password</label>
                <input name="inputPassword" type="password" class="form-control" id="inputPassword" required>
                <small id="passwordHelpInline" class="text-muted">
                    Must contain at least 8 characters, 1 number, 1 special character.
                </small>

            </div>
            <div class="form-group col-md-6">
                <label for="inputConfirmPassword">Confirm Password</label>
                <input name="inputConfirmPassword" type="password" class="form-control" id="inputConfirmPassword" required>

                <small id="cPasswordHelpInline" class="text-muted">
                    Must match password.
                </small>

            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputCountry">Country</label>
                <input name="inputCountry" id="inputCountry" class="form-control countries" type="text" placeholder="Country" required>
            </div>

            <div class="form-group col-md-4">
                <label for="inputProvince">Province/State</label>
                <input name="inputProvince" id="inputProvince" class="form-control states" type="text" placeholder="Province" required>
            </div>

            <div class="form-group col-md-4">
                <label for="inputProvince">City</label>
                <input name="inputCity" id="inputCity" class="form-control cities" type="text" placeholder="City" required>
            </div>
        </div>

        <h2 class="h2 col" >What are your interests</h2>
        <!--</form>-->  

        <!--<form action="includes/new_registration.inc.php" method="POST">-->
        <div class='interests list-group-item  flex-fill'>

            <?php
            require './includes/get_interests.inc.php';

            // output data of each row
            echo '<ul class="list-group-horizontal">';
            if (mysqli_num_rows($result) > 0) {
                $count = 0;

                while ($row = mysqli_fetch_assoc($result)) {

                    if ($count % 3 == 0) {
                        echo '<div class="row " >'; //divide
                        echo '<div class="col-lg-3 col-md-3 col-sm-12   ">';
                        echo '<div class="form-check form-check-inline "> '
                        . '<input type="checkbox" class="form-check-input " id="check' . $row['id'] . '" value="check' . $row['id'] . '" name="check[]">'
                        . '<label class="custom-check-label m-1 style="font-size: 18px; for="check' . $row['id'] . '" >' . ucfirst($row['name']) . '</label>'
                        . '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="col-lg-3 col-md-3 col-sm-12">';
                        echo '<div class="form-check form-check-inline "> '
                        . '<input type="checkbox" class="form-check-input" id="check' . $row['id'] . '" value="check' . $row['id'] . '" name="check[]" >'
                        . '<label class="form-check-label m-1 style="font-size: 18px;"  for="check' . $row['id'] . '">' . ucfirst($row['name']) . '</label>'
                        . '</div>';
                        echo '</div>';
                    }
                    $count++;

                    if ($count % 3 == 0) {
                        echo '</div>';            //closes row on third count
                    }
                }
            }
            ?>
        </div>
</div>
<span class="hr"></span>

<div class="form-row">
    <div class="form-check m-2 ">
        <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
        <label class="form-check-label" for="invalidCheck">
            Agree to <span><a href="terms_and_conditions.html">terms and conditions</a></span>
        </label>
        <div class="invalid-feedback">
            You must agree before submitting.
        </div>
    </div>
</div>

<input name="btnCreateAccount" type="submit"  class="btn btn-primary m-1" value="Create account" />



<?php
include_once'./footer.php';
?>

<script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<!--  jQuery -->
<script defer type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Bootstrap Date-Picker Plugin -->
<script defer type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>

<script defer>
    $(document).ready(function () {
        var date_input = $('input[name="dateOfBirth"]');
        var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
        var options = {
            format: 'yyyy-mm-dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
            startDate: '-150y',
            endDate: '0',
            todayBtn: true,
            clearBtn: true,
            toggleActive: true

        };
        date_input.datepicker(options);
    });

</script>