<?php
include_once './header.php';
?>

<?php
if (empty($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
?>


<link rel="stylesheet" href="styles/videoStyle.css">
        
<div class="container text-center">
    <h1 class="h1 p-1">Youtube</h1>

    <div class="row ">
        <div class=" videoBlock">
            <div class="c-videoTag ">
                <video class="videoTag " poster="media/unified-world_files.jpg" preload="metadata" >
                    <source src="media/33seconds_Illycoffee-FullCG_Trim.mp4" type="video/mp4">
                    <source src="media/33seconds_Illycoffee-FullCG_Trim.ogg" type="video/ogg">
                    Your browser does not support HTML5 video.
                </video>
                <div class="controls">
                    <div class="orange-bar">
                        <div class="orange-progress">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <p>Name of video : <b><u>illycoffee</u></b></p>
    <button type="button" id="play-pause" class="btn btn-primary">Play</button>

    <p><b>Product description :</b> Capsule Coffee Machines</p>
    <a href="#" target="_blank" >link to product...</a>
    <br>
    <br>
    <a href="dashboard.php" class="btn btn-danger">Back</a>

</div>

<script src="scripts/videoScript.js"></script>

<?php
include_once './footer.php';
?>