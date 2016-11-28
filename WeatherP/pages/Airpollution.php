<?php
// Return current date and time from the server
$number = htmlspecialchars($_GET["number"]);

//echo substr($number, 1, stripos($number,",") - 1);
//echo '<br>';
$last = substr($number, stripos($number,",") + 1, strlen($number));
//echo substr($last, 0 , strlen($last) - 1);

$lat = floor(substr($number, 1, stripos($number,",") - 1));
$lon = floor(substr($last, 0 , strlen($last) - 1));
//echo '<br>';
?>

<?php

if(isset($_GET)){
	// ----------- Get the users inpout
	// location ... 
	$user_lat = $lat;
	$user_lon = $lon;
	
	// --------------------------------
	// ----------------- connect to the API and get info based on user
	
	$api_url = "http://api.openweathermap.org/pollution/v1/co/".$user_lat.",".$user_lon."/current.json?appid=db49ff4bbf24670dd49589a903e2d06f";
	//echo $api_url;
	$weather_data = file_get_contents($api_url);
	$json = json_decode($weather_data,TRUE);
	//http://api.openweathermap.org/pollution/v1/o3/0.0,10.0/current.json?appid=db49ff4bbf24670dd49589a903e2d06f
	$api_url_o3 = "http://api.openweathermap.org/pollution/v1/o3/".$user_lat.",".$user_lon."/current.json?appid=db49ff4bbf24670dd49589a903e2d06f";
	$weather_data_o3 = file_get_contents($api_url_o3);
	$json_o3 = json_decode($weather_data_o3,TRUE);
	//-------------------------------------------------------------------
	// ------------------ GET requested info from the API
	// carbon monoxide information
	// precision
	// pressure
	// value
	$user_precision = $json['data'][0]['precision'];
	$user_pressure = $json['data'][0]['pressure'];
	$user_value = $json['data'][0]['value'];
	
	$user_o3 = $json_o3['data'];
	
	echo '<div class="form-group">
          <label>Carbon monoxide:</label>
          <p class="form-control-static">'." Precision:".$user_precision . ",<br>Pressure:" .$user_pressure. ",<br>Value:" .$user_value.'</p>
          </div>';
	echo '<div class="form-group">
          <label>Ozone layer thickness, DU:</label>
          <p class="form-control-static">'.$user_o3.'</p>
          </div>';
	
	//echo "Carbon monoxide information : "; echo '<br>';
	//echo " Precision:".$user_precision . ",<br>Pressure:" .$user_pressure. ",<br>Value:" .$user_value;
	//echo '<br>' . " Ozone layer thickness, DU:" .$user_o3;
	
	
};

?>