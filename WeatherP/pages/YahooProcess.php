<?php
// Return current date and time from the server
$number = htmlspecialchars($_GET["number"]);

//echo substr($number, 1, stripos($number,",") - 1);
//echo '<br>';
$last = substr($number, stripos($number,",") + 1, strlen($number));
//echo substr($last, 0 , strlen($last) - 1);

$lat = substr($number, 1, stripos($number,",") - 1);
$lon = substr($last, 0 , strlen($last) - 1);
//echo '<br>';
?>
<?php

	$user_lat = $lat;
	$user_lon = $lon;
	

    $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
    //$yql_query = 'select wind from weather.forecast where woeid in (select woeid from geo.places(1) where text="({'.$user_lat.'},{'.$user_lon.'})")';
	$yql_query = 'select wind from weather.forecast where woeid in (select woeid from geo.places(1) where text="('.$user_lat.','.$user_lon.')")';
	
	//echo $yql_query;
    $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
    // Make call with cURL
    $session = curl_init($yql_query_url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
    $json = curl_exec($session);
    // Convert JSON to PHP object
     $phpObj =  json_decode($json,TRUE);
	 
	 $user_chill = $phpObj['query']['results']['channel']['wind']['chill'];
	 //direction
	 $user_direction = $phpObj['query']['results']['channel']['wind']['direction'];
	 //speed
	 $user_speed = $phpObj['query']['results']['channel']['wind']['speed'];
	 	echo '<div class="form-group">
          <label>Wind:</label>
          <p class="form-control-static">'." chill:".$user_chill . "<br>direction:" .$user_direction. "<br>Speed:" .$user_speed.'</p>
          </div>';
	 
    //var_dump($phpObj);
?>