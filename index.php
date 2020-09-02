<!DOCTYPE html>

<?php
require './header.php';
?>


<?php
if (isset($_GET['error'])) {
    if ($_GET['error'] = 'nosession') {
        ?>
        <div class='text-center alert alert-info alert-dismissible fade show'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <strong>Message!</strong> You need to be logged in.
        </div>

        <?php
    }
}

if (isset($_GET['message']) && $_GET['message'] == "success") {
    ?>
    <div class='text-center alert alert-success alert-dismissible fade show'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
        <strong>Message!</strong>You have been registered, please check your email to activate your account.
    </div>
    <script>alert('Registration successful, please verify your account via your email.')</script>
    <?php
}
?>

<div class="container-fluid text-center" >
    <h2 class="h2" >About Us</h2>

    <p>We help you organize your digital life so you always stay upto date and trendy.</p>

</div>

    <div class="card-group ">
        <div class="card">
            <img class="card-img-top" src="media/youtube.jpg" alt="YouTube image cap">
            <div class="card-body">
                <h5 class="card-title">YouTube</h5>
                <p class="card-text">Which trends and influences are breaking the internet? </p>
            </div>
        </div>
        <div class="card ">
            <img class="card-img-top" src="media/spotify.jpg" alt="Spotify image cap">
            <div class="card-body">
                <h5 class="card-title">Spotify</h5>
                <p class="card-text">Whats hot in the music scene?</p>
            </div>
        </div>
        <div class="card ">
            <img class="card-img-top" src="media/instargram.jpg" alt="Instagram image cap" >
            <div class="card-body">
                <h5 class="card-title">Instagram</h5>
                <p class="card-text">What are the latest challenges and trends which influences are shaking things up?</p>
            </div>
        </div>
    </div>

<?php
require './footer.php';
