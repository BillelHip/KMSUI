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
include('forecast.io.php');

$api_key = '14f4c4160eeba8304f430f6c1cf170de';

$latitude = $lat;
$longitude = $lon;
$units = 'auto';  // Can be set to 'us', 'si', 'ca', 'uk' or 'auto' (see forecast.io API); default is auto
$lang = 'en'; // Can be set to 'en', 'de', 'pl', 'es', 'fr', 'it', 'tet' or 'x-pig-latin' (see forecast.io API); default is 'en'

$forecast = new ForecastIO($api_key, $units, $lang);

// all default will be
// $forecast = new ForecastIO($api_key);


/*
 * GET CURRENT CONDITIONS
 */
$condition = $forecast->getCurrentConditions($latitude, $longitude);
	echo '<div class="form-group">
          <label>Current temperature: </label>
          <p class="form-control-static">'.$condition->getTemperature().'</p>
          </div>';
//echo 'Current temperature: '.$condition->getTemperature(). "\n";


/*
 * GET HOURLY CONDITIONS FOR TODAY
 */
$conditions_today = $forecast->getForecastToday($latitude, $longitude);

//echo "\n\nTodays temperature:\n";
echo '<div class="form-group">
          <label>Todays temperature: </label>';

foreach($conditions_today as $cond) {

    //echo $cond->getTime('H:i:s') . ': ' . $cond->getTemperature(). "\n";
	echo '<p class="form-control-static">'. $cond->getTime('H:i:s') . ': ' . $cond->getTemperature(). '</p>
          </div>';

}

/*
 * GET DAILY CONDITIONS FOR NEXT 7 DAYS
 */
$conditions_week = $forecast->getForecastWeek($latitude, $longitude);

//echo "\n\nConditions this week:\n";
echo '<div class="form-group">
          <label>Conditions this week: </label>';

foreach($conditions_week as $conditions) {

   //echo $conditions->getTime('Y-m-d') . ': ' . $conditions->getMaxTemperature() . "\n";
	echo '<p class="form-control-static">'. $conditions->getTime('Y-m-d') . ': ' . $conditions->getMaxTemperature(). '</p>
          </div>';

}

/*
 * GET HISTORICAL CONDITIONS
 */
$condition = $forecast->getHistoricalConditions($latitude, $longitude, '2010-10-10T14:00:00-0700');

//echo "\n\nTemperatur 2010-10-10: ". $condition->getMaxTemperature(). "\n";
echo '<div class="form-group">
          <label>Temperatur 2010-10-10: </label>';
		  echo '<p class="form-control-static">'. $condition->getMaxTemperature(). '</p>
          </div>';


