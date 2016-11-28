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
//http://api.wunderground.com/api/be12ea068f91205c/tide/q/37.776289,-122.395234.json


	$user_lat = $lat;
	$user_lon = $lon;
	//echo $lat . " , " . $lon . "\n";
	$length_lon = $user_lon;
	$length_lon = floor(($length_lon) * 1000 + .5) * .001;
	$length_lat = $user_lat;
	$length_lat = floor(($length_lat) * 1000 + .5) * .001;
	//print "$length_lat , $length_lon \n";
	
	$api_url = "http://api.wunderground.com/api/be12ea068f91205c/tide/q/".$length_lat.",".$length_lon . ".json";
	//            http://api.wunderground.com/api/be12ea068f91205c/tide/q/-26.714210,130.3769555.json
	//$api_url = "http://api.wunderground.com/api/be12ea068f91205c/tide/q/37.776289,-122.395234.json";
	//echo $api_url;
	$weather_data = file_get_contents($api_url);
	$json = json_decode($weather_data,TRUE);

	
	
	/// --------- 
	/*
	 $user_chill = $phpObj['query']['results']['channel']['wind']['chill'];
	 //direction
	 $user_direction = $phpObj['query']['results']['channel']['wind']['direction'];
	 //speed
	 $user_speed = $phpObj['query']['results']['channel']['wind']['speed'];
	 	echo '<div class="form-group">
          <label>Wind:</label>
          <p class="form-control-static">'." chill:".$user_chill . "<br>direction:" .$user_direction. "<br>Speed:" .$user_speed.'</p>
          </div>';
	 */
	 
	 /*
	 $str = '{ 

"players":
[
		{
		"tideSite":"",
		"lat":"",
		"lon":"",
		"units":"",
		"type":"",
		"tzname":""
		}
		]
}';

 $arr = json_decode($str, true);
 $arrne['name'] = "dsds";
 array_push( $arr['players'], $arrne );
 print_r($arr);
 */
 
	 //$test = $json['tide']['tideInfo'];
	 //count
	 if(count($json['tide']['tideSummary']) > 0){
		for($i = 0 ; $i < count($json['tide']['tideSummary']);  $i++){
			
				echo '<div class="form-group">
          <label>Date : '.$json['tide']['tideSummary'][$i]['utcdate']['pretty'].'</label>
          <p class="form-control-static">Height : '.$json['tide']['tideSummary'][$i]['data']['height']."<br> Type : ".$json['tide']['tideSummary'][$i]['data']['type']. '</p>
          </div>';
		
			//print_r("Date : ".$json['tide']['tideSummary'][$i]['utcdate']['pretty'] . "<br>");
			//print_r("Height : ".$json['tide']['tideSummary'][$i]['data']['height'] . "<br>");
			//print_r("Type : ".$json['tide']['tideSummary'][$i]['data']['type'] . "<br>");
		}
	 	
	 }
    //var_dump($phpObj);

?>
