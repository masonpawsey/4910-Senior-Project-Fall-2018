<?php
session_start();
require_once 'vendor/autoload.php';

use PHPAuth\Config as PHPAuthConfig;
use PHPAuth\Auth as PHPAuth;

require_once('credentials.php');
$dbh = new PDO('mysql:host=localhost;dbname=tweets', $user, $pass);

$config = new PHPAuthConfig($dbh);
$auth = new PHPAuth($dbh, $config);

if ($auth->isLogged()) {
	header("Location: home.php");
	die('You are logged in');
}
?>
<html>
<head>
	<meta charset='utf-8' />
	<title>sylvstrr</title>
	<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
	<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js'></script>
	<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.css' rel='stylesheet' />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.13/css/mdb.min.css" rel="stylesheet">
	<script
	  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
	  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
	  crossorigin="anonymous"></script>
	<!-- MDB core JavaScript -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.13/js/mdb.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script type="text/javascript" src="cities.js"></script>
	<link rel="stylesheet" href="style.css">
	<link rel="icon" type="image/png" href="./assets/favicon.png">
</head>

<body>
	<main role="main" class="container-fluid no-gutters">
		<div class="row">
			<div id="map">
			</div>
			<div class="col"></div>
			<div class="col text-center no-gutters header">
				<h1>sylvstrr</h1>
			</div>
		</div>
		<div class="row">
			<div class="col"></div>
			<div class="col header-text">
				<div class="row">
					<div class="col-md-12 col-lg-3"></div>
					<div class="col-md-12 col-lg-6 header-text">
						register your account
					</div>
					<div class="col-md-12 col-lg-3"></div>
				</div>
			</div>
		</div>
		<br><br><br>
		<form>
			<div class="row">
				<div class="col-6"></div>
				<div class="col-6">
					<div class="row">
						<div class="col-md-12 col-lg-6 input-effect">
							<div class="md-form">
								<input type="email" autocomplete="off" id="email" name="email" class="form-control">
								<label for="email" class="float-up">Email</label>
							</div>
						</div>
						<div class="col-md-12 col-lg-6 input-effect">
							<div class="md-form">
						    	<input type="password" autocomplete="off" class="form-control" name="password" id="password">
						    	<label for="password" class="float-up">Password</label>
						    	<span class="help d-none">Don't write hunter2...</span>
						    </div>
					    </div>
					</div>
				</div>
			</div>
			<br><br>
			<div class="row">
				<div class="col"></div>
				<div class="col text-center">
					<input type="submit" class="btn btn-success submit" data-toggle="button" value="Register" aria-pressed="false" autocomplete="off">
				</div>
			</div>
		</form>
		<div class="row">
			<div class="col"></div>
			<div class="col text-center">
				<a href="../">Already have an account?</a>
			</div>
		</div>
	</main>
	<script>
	mapboxgl.accessToken = 'pk.eyJ1IjoibWFzb25wYXdzZXkiLCJhIjoiY2puemkzb3N0MWY4djNra2JsZzBpaXpicSJ9.O8dFlt7FrskfE-GL8qvBUA';
	var map = new mapboxgl.Map({
		container: 'map', // container id
		style: 'mapbox://styles/masonpawsey/cjnzi73pd85jn2rmnm1oj9g65', // stylesheet location
		center: [-122.43512,37.761], // starting position [lng, lat]
		zoom: 17,
		interactive: false
	});

	var map_locations = [{
		// CSUB
	    "id": "2",
	    "camera": {
	    	speed: 0.1,
	        center: [-119.10506171751422,35.347574509536656],
	        zoom: 14.75,
	        pitch: 50
	    }
	}, {
		// White House
	    "id": "3",
	    "camera": {
	    	speed: 0.1,
	        center: [-77.03657390000001, 38.8976633],
	        zoom: 17
	    }
	}, {
		// Kremlin
	    "id": "1",
	    "camera": {
	    	speed: 0.1,
	        center: [37.61749940000004,55.7520233],
	        zoom: 16,
	        pitch: 25
	    }
	}, {
		// Trump Tower
	    "id": "4",
	    "camera": {
	    	speed: 0.1,
	        center: [-73.973869,40.762459], // starting position [lng, lat]
	        zoom: 17
	    }
	}, {
		// Buckingham Palace
	    "id": "5",
	    "camera": {
	    	speed: 0.1,
	    	center: [-0.140634, 51.501476], // starting position [lng, lat]
	    	zoom: 15,
	    	pitch: 75,
	    	yaw: 25,
	    }
	}, {
		// mar - a - lago
		"id": "6",
	    "camera": {
	    	speed: 0.1,
	        center: [-80.037980,26.676820], // starting position [lng, lat]
	        zoom: 17
	    }
	 }, {
	 	// the castro
		"id": "7",
	    "camera": {
	    	speed: 0.1,
	        center: [-122.43512,37.761], // starting position [lng, lat]
	        zoom: 17,
	    }
	}, {
	 	// the bean
		"id": "8",
	    "camera": {
	    	speed: 0.1,
	        center: [-87.620659184,41.8762748282], // starting position [lng, lat]
	        zoom: 17,
	    }
	}];

	function playback(index) {
	    // Animate the map position based on camera properties
	    map.flyTo(map_locations[index].camera);

	    map.once('moveend', function() {
	        // Duration the slide is on screen after interaction
	        window.setTimeout(function() {
	            // Increment index
	            index = (index + 1 === map_locations.length) ? 0 : index + 1;
	            playback(index);
	        }, 3000); // After callback, show the location for 3 seconds.
	    });
	}

	map.on('load', function() {
	    // Start the playback animation for each borough
	    // playback(0);
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

		// Gonna need to validate these some more...
		$('.submit').on('click', function() {
			var formdata = $("form").serialize();
			$.ajax({
				url: 'register.php',
				type: 'POST',
				data: formdata,
				dataType: "json",
				success: function (result) {
					if(result['error'] === true) {
						toastr.error(result['message'], result['title'] || 'Error');
					} else {
						toastr.success(result['message'], result['title'] || 'Success',  { timeOut: 1500, onHidden: function() { window.location.href = "home.php"; }});
					}
					console.log(result);
				}
			});
		});

		$('#password').on('focus', function() {
			$('.help').removeClass("d-none");
			$('.help').addClass("d-block");
		});

		$('#password').on('blur', function() {
			$('.help').removeClass("d-block");
			$('.help').addClass("d-none");
		});

		$('#password').on('keyup', function() {
			if($(this).val().toLowerCase() == 'hunter2') {
				$(this).val('');
				toastr.error('Are you trying to be hacked?', 'ID-10-T error');
			}
		});

		// Cities are included in cities.js above
		$("#location").autocomplete({
			source: cities
		});
	});
	</script>
</body>

</html>
