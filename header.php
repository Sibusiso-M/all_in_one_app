<?php
session_start();
?>


<!--Fund raise-->

<html lang="en">
    <head >
        <meta charset="UTF-8">
        <title>Hashtag</title>

        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">

        <!-- Bootstrap -->

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.css">
        <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/styles.css">
        <link rel="stylesheet" href="styles/generalStyles.css">

        <!--  -->        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
    </head>
    <body>
        <!--        <header class="fixed-top">-->
        <nav id="navbarcust" class="navbar navbar-expand-lg navbar-light fixed-top position-sticky" >
            <a class="navbar-brand" href="index.php">
                <img id="logo-image" class="img-fluid" src="media/grunge-hashtag-1.png" alt="hashtag logo" >Hashtag</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapseNavbarNav">
                <span class="navbar-toggler-icon float-right"></span>
            </button>
            <div class="collapse navbar-collapse navbar-expand-sm" id="collapseNavbarNav">


                <?php
                if (!empty($_SESSION['id'])) {
                    ?>
                    <ul class="navbar-nav mr-auto mt-0 mt-lg-0">
                        <li class = "nav-item">
                            <a class = "nav-link" href = "index.php">Home<span class = "sr-only">(current)</span></a>
                        </li>
                        <li class = "nav-item" hidden>
                            <a class = "nav-link" href = "events.php">Events</a>
                        </li>
                        <li class = "nav-item">
                            <a class = "nav-link" href = "dashboard.php">Dashboard</a>
                        </li>
                        <li>
                            <a class = "nav-link" href = "my-profile.php">My Profile</a>
                        </li> 
                    </ul>
                    <?php
                } else {
                    ?>
                    <ul class="navbar-nav mr-auto mt-0 mt-lg-0">
                        <li class = " nav-item">
                            <a class = "nav-link link-cust" href = "index.php">Home<span class = "sr-only">(current)</span></a>
                        </li>
                        <li class = "nav-item">
                            <a class = "nav-link" href = "events.php" hidden >Events</a>
                        </li> 
                    </ul>
                    <?php
                }
                ?>


                <?php
                if (!empty($_SESSION['id']) && $_SESSION['id'] !== "Guest") {                             //   filter_var(INPUT_SESSION,'idUser')
                    $id = $_SESSION['id'];

                    include './includes/conn.inc.php';
                    $sqlUserName = "SELECT first_name FROM tbl_user WHERE id =" . $id;
                    $results = mysqli_query($conn, $sqlUserName);

                    if (mysqli_num_rows($results) > 0) {
                        while ($rowUser = mysqli_fetch_assoc($results)) {
                            $firstName = $rowUser['first_name'];
                        }
                    }
                    ?>

                    <ul class = "nav navbar-item">
                        <li class="nav-item float-right ">
                            <form action="./includes/logout.inc.php" method="post">
                                <p class="text-center d-inline-block"><a class=" btn  m-1" href="./my-profile.php"> <?php echo "Hi, $firstName !"; ?></a></p>
                                <button class="btn btn-dark m-1" type="submit" name="btnLogout-submit">Log out</button>
                            </form>
                        </li>
                    </ul>

                    <?php
                } elseif (!empty($_SESSION['id']) && $_SESSION['id'] == "Guest") {
                    $firstName = $_SESSION['id'];
                    ?>

                    <ul class = "nav navbar-item">
                        <li class="nav-item float-right ">
                            <form action="./includes/logout.inc.php" method="post">
                                <p class="text-center d-inline-block"><a class=" btn-link m-1" href="./my-profile.php"> <?php echo "Hi,$firstName!"; ?></a></p>
                                <button class="btn btn-dark m-1" type="submit" name="btnLogout-submit">Log out</button>
                            </form>
                        </li>
                    </ul>

                    <?php
                } else {
                    ?> 
                    <form action="./includes/logout.inc.php" method="post">
                        <ul class = "nav navbar-item">
                            <li class="nav-item nav-item-cust" >
                                <span class=""><a class="btn btn-outline-danger m-1" href="./registration.php">Register</a></span> <!--icon-->
                            </li>
                            <li class="nav-item nav-item-cust" >
                                <span class=""><a class="btn btn-outline-info m-1" href="./sign-in.php">Sign In</a></span><!--icon-->
                            </li>
                        </ul> 
                    </form>



                    <?php
                }
                ?>                                      
            </div>  
        </nav>
        <!--        </header>-->