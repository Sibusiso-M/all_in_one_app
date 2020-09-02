
<?php
require './header.php';
?>

<?php
//Content control

if (empty($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
?>



<div class="container-fluid align-content-center">

    <!--        Graphs and diagrams        -->

    <div class="jumbotron text-center" >
        <h1 class="h1">Welcome <span><b>    </b></span></h1>
        <p>Great to have you here!</p> 
    </div>


    <div class="row">
        <div class="col-sm-12 col-md-6 text-center m-0 ">
            <div class="card mb-4">
                <h2 class="card-title">YouTube</h2>
                <p class="card-text">Videos sorted according to your interests</p>
                <a class="btn btn-info  m-1" href="video.php" role="button">View</a>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 text-center m-0">
            <div class="card mb-4">
                <h2 class="card-title">Spotify</h2>
                <p class="card-text">Music sorted according to your interests.</p>
                <a class="btn btn-info m-1" href="audio.php" role="button">View</a>
            </div>
        </div>

        <div class="w-100"></div>

        <!--   Force next columns to break to new line at breakpoint and up -->

        <div class="col-sm-12  text-center m-0">
            <div class="card mb-4">
                <h2 class="card-title">Instagram</h2>
                <p class="card-text">Photos sorted according to your interests.</p>
                <a class="btn btn-info  m-1" href="banner.php" role="button">View</a>
            </div>
        </div>

    </div>
</div> 
<?php
require './footer.php';
