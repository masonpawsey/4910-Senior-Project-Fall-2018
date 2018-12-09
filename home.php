<?php
session_start();
require_once 'vendor/autoload.php';

use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

require_once('credentials.php');
$dbh = new PDO('mysql:host=localhost;dbname=tweets', $user, $pass);

$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);

if (!$auth->isLogged()) {
	header("Location: index.php");
	die('Forbidden');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sylvester</title>
    <!-- Boostrap CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.13/js/mdb.min.js"></script>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.css' rel='stylesheet' />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.13/css/mdb.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="home-style.css">
    <script type="text/javascript" src="cities.js"></script>
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">

                    </a>
                </li>
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li>
                    <a href="#">Shortcuts</a>
                </li>
                <li>
                    <a href="#">Overview</a>
                </li>
                <li>
                    <a href="#">Events</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <header>
                <!-- Fixed navbar -->
                <nav class="navbar navbar-expand fixed-top">
                    <a class="navbar-brand" href="#">sylvester</a>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></a>
                            </li>
                        </ul>
                    </div>
                    <img class="rounded-circle" style="width:35px; margin: 0 10px;" src="https://randomuser.me/api/portraits/men/10.jpg" alt="">
                  <li class="nav-item dropdown" style="list-style: none;">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $auth->getCurrentUser()['email']; ?>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Profile</a>
                            <a class="dropdown-item" href="logout.php">Log out</a>
                          </div>
                        </li>
                </nav>
            </header>
            <!-- Begin page content -->
            <main role="main" class="container-fluid">
                <div class="row" style="margin-top: 60px">
                    <div class="col-sm-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><strong>New search</strong></h5>
                                <div class="row">
                                    <div class="col-md-12 col-lg-5 input-effect">
                                    	<form action="search.php" method="POST">
                                        <div class="md-form">
                                            <input type="text" autocomplete="off" id="keyword" name="keyword" class="form-control">
                                            <label for="keyword" class="float-up keyword-label">Keywords</label>
                                            <span class="help d-none">Separate keywords with a space</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-5 input-effect">
                                        <div class="md-form">
                                            <input type="text" autocomplete="off" class="form-control" name="location" id="location">
                                            <label for="location" class="float-up location-label">Location</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-2">
                                        <div class="md-form">
                                            <input type="submit" class="btn btn-hollow">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      <br>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                  <div class="col">
                                    <h5 class="card-title"><strong>Map for <u>Tacos</u> in <u>Bakersfield, United States</u></strong></h5>
                                  </div>
                                  <div class="col text-right">
                                    <a href="#"><i class="fas fa-arrow-circle-up"></i> Share</a>
                                  </div>
                                </div>
                              </h5>
                              <div id="map" style="height: 58vh"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Trending on Twitter</strong></h5>
                                <p class="card-text">You might want to try combining these trending keywords and locations</p>
                                <div class="row">
                                  <div class="col">
                                    <h5 class="card-title"><strong>Keywords</strong></h5>
                                    <p class="card-text">
                                      <ul>
                                        <li>Tacos</li>
                                        <li>Burritos</li>
                                        <li>Quesadillas</li>
                                      </ul>
                                    </p>
                                  </div>
                                  <div class="col">
                                    <h5 class="card-title"><strong>Locations</strong></h5>
                                    <p class="card-text">
                                      <ul>
                                        <li>Bakersfield, United States</li>
                                        <li>Miami, United States</li>
                                        <li>New York City, United States</li>
                                      </ul>
                                    </p>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Your recent searches</strong></h5>
                                <!-- <p class="card-text">We'll keep track of your searches right here so you can come back and reference them</p> -->
                                <p class="card-text">
                                  <div class="row">
                                    <div class="col-8">
                                      <i class="fas fa-keyboard"></i> Tacos <br><i class="fas fa-map-marker"></i> Bakersfield, United States <br><i class="fas fa-clock"></i> 9 Dec 2018 1:12 am
                                    </div>
                                    <div class="col-4">
                                      <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">View map</button>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col-8">
                                      <i class="fas fa-keyboard"></i> Burritos <br><i class="fas fa-map-marker"></i> Bakersfield, United States <br><i class="fas fa-clock"></i> 9 Dec 2018 1:10 am
                                    </div>
                                    <div class="col-4">
                                      <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">View map</button>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col-8">
                                      <i class="fas fa-keyboard"></i> Quesadillas <br><i class="fas fa-map-marker"></i> Bakersfield, United States <br><i class="fas fa-clock"></i> 9 Dec 2018 1:08 am
                                    </div>
                                    <div class="col-4">
                                      <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">View map</button>
                                    </div>
                                  </div>
                                  <br>
                                </p>
                            </div>
                            <div class="card-footer text-right">
                              <small class="text-muted">See more <i class="fas fa-arrow-circle-right"></i></small>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Debug</strong></h5>
                                <pre>
                                	<?php
                                	// print_r($_SESSION['hash']);
                                	print_r($auth->getCurrentUser()['email']);
                                	?>
                                </pre>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <!-- /#page-content-wrapper -->
        <!-- /#wrapper -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-6"><a href='https://www.mapbox.com/about/maps/' target='_blank'>Maps &copy; Mapbox &copy; OpenStreetMap</a></div>
                  <div class="col-6 text-right">Team Sylvester</div>
                </div>
            </div>
        </footer>
    </div>
    <script>
    mapboxgl.accessToken = 'pk.eyJ1IjoibWFzb25wYXdzZXkiLCJhIjoiY2puemkzb3N0MWY4djNra2JsZzBpaXpicSJ9.O8dFlt7FrskfE-GL8qvBUA';
    var map = new mapboxgl.Map({
        container: 'map', // container id
        style: 'mapbox://styles/masonpawsey/cjnzi73pd85jn2rmnm1oj9g65', // stylesheet location
        center: [-119.10506171751422, 35.34757450953665], // starting position [lng, lat]
        zoom: 4,
        interactive: true
    });

    $(document).ready(function() {
        $('input').focus(function() {
            $(this).next('.float-up').addClass('active');
        });

        $('input').focusout(function() {
            if ($(this).val().length < 1) {
                $(this).next('.float-up').removeClass('active');
            }
        });

        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
            $('.navbar-collapse').toggleClass("padded");
        });

        $('#keyword').on('focus', function() {
            $('.help').removeClass("d-none");
            $('.help').addClass("d-block");
        });

        $('#keyword').on('blur', function() {
            $('.help').removeClass("d-block");
            $('.help').addClass("d-none");
        });

        // Cities are included in cities.js above
        $("#location").autocomplete({
            source: cities
        });
    });
    </script>
</body>

</html>