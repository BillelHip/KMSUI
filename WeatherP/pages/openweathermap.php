<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../imgs/weather-icon.png">
<title>Weather Prediction</title>

<!-- Bootstrap Core CSS -->
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="../vendor/morrisjs/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<style>
#map {
	height: 300px;
	width: 100%;
}
</style>
</head>

<body>
<div id="wrapper">
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> </button>
    <a class="navbar-brand" href="index.php"><div class="fa-2x">Weather Prediction</div></a> </div>
  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
      <ul class="nav" id="side-menu">
        <li> <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a> </li>
        <li> <a href="openweathermap.php"><i class="fa fa-sun-o fa-fw"></i> Open Weather Map API</a> </li>
        <li> <a href="yahoo.php"><i class="fa fa-yahoo fa-fw"></i> Yahoo Weather API </a> </li>
        <li> <a href="forecast.php"><i class="fa fa-cloud fa-fw"></i> Forecast IO API </a> </li>
        <li> <a href="underground.php"><i class="fa fa-thermometer-full fa-fw"></i> Weather Underground API </a> </li>
      </ul>
    </div>
    <!-- /.sidebar-collapse --> 
  </div>
  <!-- /.navbar-static-side --> 
</nav>
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Open Weather Map API</h1>
    </div>
    <!-- /.col-lg-12 --> 
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading"> Google Maps APIs </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-6">
              <div id="map"></div>
            </div>
            <!-- /.col-lg-6 (nested) -->
            <div class="col-lg-6"> 
            	<div id="name_feedback"></div> 
            </div>
            <!-- /.col-lg-6 (nested) -->
          </div>
          <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
      </div>
      <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
    
    <div class="col-lg-3 col-md-6"> 
      <script>
	function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: {lat: -25.363882, lng: 131.044922 }
        });

        map.addListener('click', function(e) {
          placeMarkerAndPanTo(e.latLng, map);
        });
      }

      function placeMarkerAndPanTo(latLng, map) {
        var marker = new google.maps.Marker({
          position: latLng,
          map: map
        });
        map.panTo(latLng);
		google.maps.event.addListenerOnce(map, 'click', function() {
			var numValue = latLng+"";
			$.get("Airpollution.php", {number: numValue} , function(data){
				// Display the returned data in browser
				$("#name_feedback").html(data);
			});
        });
      }
    </script> 
      <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA665aDyAPFDgxFO5H4t12jyRqIQX-6x6I&callback=initMap">
    </script> 
    </div>
    <!-- /.row --> 
  </div>
  <!-- /#page-wrapper --> 
</div>
<!-- /#wrapper --> 

<!-- jQuery --> 
<script src="../vendor/jquery/jquery.min.js"></script> 

<!-- Bootstrap Core JavaScript --> 
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script> 

<!-- Metis Menu Plugin JavaScript --> 
<script src="../vendor/metisMenu/metisMenu.min.js"></script> 

<!-- Morris Charts JavaScript --> 
<script src="../vendor/raphael/raphael.min.js"></script> 
<script src="../vendor/morrisjs/morris.min.js"></script> 
<script src="../data/morris-data.js"></script> 

<!-- Custom Theme JavaScript --> 
<script src="../dist/js/sb-admin-2.js"></script>
</body>
</html>
