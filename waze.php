<?php
include('common.php');

$query = $conn->prepare("SELECT * FROM config");
$query->execute();
$config = $query->fetchAll();

foreach($config as $c) {
    ${$c['config_option']} = $c['config_value'];
}

// Waze configurable data values
$home_lat = $waze_home_lat;
$home_long = $waze_home_long;
$work_lat = $waze_work_lat;
$work_long = $waze_work_long;
$num_routes = $waze_paths;

// Fetch Waze traffic data from the RoutingManager using the Latitude and Longitude of the Home and Work addresses.
// These are set in the local database in the config table.
$curl_handle=curl_init();
curl_setopt($curl_handle, CURLOPT_URL,'https://www.waze.com/RoutingManager/routingRequest?from=x%3A'.$home_long.'+y%3A'.$home_lat.'+bd%3Atrue&to=x%3A'.$work_long.'+y%3A'.$work_lat.'+bd%3Atrue&returnJSON=true&returnGeometries=true&returnInstructions=true&timeout=60000&nPaths='.$num_routes);
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_USERAGENT, 'SimplyDashing');
$waze_json = curl_exec($curl_handle);
curl_close($curl_handle);

// Decode json data to be used.
$waze_data = json_decode($waze_json, true);

// Set counters for variables
$rc = 0;
$rd = 0;

// Loop through the json data feed and set the variables to be used for displaying data.
foreach ($waze_data['alternatives'] as $routes) {
    ${'routeName_'.$rc} = $routes['response']['routeName'];
    ${'routeRealTime_'.$rc} = 0;
    ${'routeTime_'.$rc} = 0;
    ${'routeDist_'.$rc} = 0;
    foreach ($routes['response']['results'] as $route_data) {
        ${'routeRealTime_'.$rc} = ${'routeRealTime_'.$rc} + $route_data['crossTime'];
        ${'routeTime_'.$rc} = ${'routeTime_'.$rc} + $route_data['crossTimeWithoutRealTime'];
        ${'routeDist_'.$rc} = ${'routeDist_'.$rc} + $route_data['length'];
        $rd++;
    }
    ${'routeETA_'.$rc} = (${'routeRealTime_'.$rc} + time());
    ${'routeETA_'.$rc} = date("g:i a",${'routeETA_'.$rc});
    ${'routeRealTime_'.$rc} = ceil(${'routeRealTime_'.$rc} / 60);
    ${'routeTime_'.$rc} = ceil(${'routeTime_'.$rc} / 60);
    ${'routeDist_'.$rc} = ${'routeDist_'.$rc} * 0.00062137;
    ${'routeDist_'.$rc} = round(${'routeDist_'.$rc},2);

    $rc++;
}

?>