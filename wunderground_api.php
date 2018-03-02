<?php
// Configuration settings for Wunderground API.
$api_key = '58eb7df2ce579f40';
$api_city = 'Langhorne';
$api_state = 'PA';
$api_pws_id = '';

// Get conditions json
$conditions_json = file_get_contents("http://api.wunderground.com/api/".$api_key."/conditions/q/".$api_state."/".$api_city.".json");
$conditions_array = json_decode($conditions_json, true);

//Location Data
$location = $conditions_array['current_observation']['display_location']['full'];
$city = $conditions_array['current_observation']['display_location']['city'];
$location_state = $conditions_array['current_observation']['display_location']['state'];
$location_state_name = $conditions_array['current_observation']['display_location']['state_name'];
$location_country = $conditions_array['current_observation']['display_location']['country'];
$location_country_iso3166 = $conditions_array['current_observation']['display_location']['country_iso3166'];
$location_zip = $conditions_array['current_observation']['display_location']['zip'];
$location_latitude = $conditions_array['current_observation']['display_location']['latitude'];
$location_longitude = $conditions_array['current_observation']['display_location']['longitude'];
$location_elevation = $conditions_array['current_observation']['display_location']['elevation'];

// Observation Location
$station_id = $conditions_array['current_observation']['station_id'];
$obs_location = $conditions_array['current_observation']['observation_location']['full'];
$station_city = $conditions_array['current_observation']['observation_location']['city'];
$station_state = $conditions_array['current_observation']['observation_location']['state'];
$station_country = $conditions_array['current_observation']['observation_location']['country'];
$station_country_iso3166 = $conditions_array['current_observation']['observation_location']['country_iso3166'];
$station_latitude = $conditions_array['current_observation']['observation_location']['latitude'];
$station_longitude = $conditions_array['current_observation']['observation_location']['longitude'];
$station_elevation = $conditions_array['current_observation']['observation_location']['elevation'];

// Current Conditions
$observation_time = $conditions_array['current_observation']['observation_time'];
$weather = $conditions_array['current_observation']['weather'];
$temperature_string = $conditions_array['current_observation']['temperature_string'];
$temp_f = $conditions_array['current_observation']['temp_f'];
$temp_c = $conditions_array['current_observation']['temp_c'];
$relative_humidity = $conditions_array['current_observation']['relative_humidity'];
$wind_string = $conditions_array['current_observation']['wind_string'];
$wind_dir = $conditions_array['current_observation']['wind_dir'];
$wind_degrees = $conditions_array['current_observation']['wind_degrees'];
$wind_mph = $conditions_array['current_observation']['wind_mph'];
$wind_gust_mph = $conditions_array['current_observation']['wind_gust_mph'];
$wind_kph = $conditions_array['current_observation']['wind_kph'];
$wind_gust_kph = $conditions_array['current_observation']['wind_gust_kph'];
$pressure_mb = $conditions_array['current_observation']['pressure_mb'];
$pressure_in = $conditions_array['current_observation']['pressure_in'];
$pressure_trend = $conditions_array['current_observation']['pressure_trend'];
$dewpoint_string = $conditions_array['current_observation']['dewpoint_string'];
$dewpoint_f = $conditions_array['current_observation']['dewpoint_f'];
$dewpoint_c = $conditions_array['current_observation']['dewpoint_c'];
$heat_index_string = $conditions_array['current_observation']['heat_index_string'];
$heat_index_f = $conditions_array['current_observation']['heat_index_f'];
$heat_index_c = $conditions_array['current_observation']['heat_index_c'];
$windchill_string = $conditions_array['current_observation']['windchill_string'];
$windchill_f = $conditions_array['current_observation']['windchill_f'];
$windchill_c = $conditions_array['current_observation']['windchill_c'];
$feelslike_string = $conditions_array['current_observation']['feelslike_string'];
$feelslike_f = $conditions_array['current_observation']['feelslike_f'];
$feelslike_c = $conditions_array['current_observation']['feelslike_c'];
$visibility_mi = $conditions_array['current_observation']['visibility_mi'];
$visibility_km = $conditions_array['current_observation']['visibility_km'];
$solarradiation = $conditions_array['current_observation']['solarradiation'];
$UV = $conditions_array['current_observation']['UV'];
$precip_1hr_in = $conditions_array['current_observation']['precip_1hr_in'];
$precip_1hr_metric = $conditions_array['current_observation']['precip_1hr_metric'];
$precip_today_string = $conditions_array['current_observation']['precip_today_string'];
$precip_today_in = $conditions_array['current_observation']['precip_today_in'];
$precip_today_metric = $conditions_array['current_observation']['precip_today_metric'];
$icon = $conditions_array['current_observation']['icon'];
$icon_url = $conditions_array['current_observation']['icon_url'];

//Get 10 Day Forecast json
$forecast_json = file_get_contents("http://api.wunderground.com/api/".$api_key."/forecast10day/q/".$api_state."/".$api_city.".json");
$forecast_array = json_decode($forecast_json, true);

$txt_forecast = $forecast_array['forecast']['txt_forecast']['forecastday'];
$tf_count = count($txt_forecast);
for($tf = 0; $tf < $tf_count; $tf++)
{
    $tforecast = $txt_forecast[$tf];
    ${'tf_icon_'.$tf} = $tforecast['icon'];
    ${'tf_icon_url_'.$tf} =  $tforecast['icon_url'];
    ${'tf_title_'.$tf} =  $tforecast['title'];
    ${'tf_fcttext_'.$tf} =  $tforecast['fcttext'];
    ${'tf_fcttext_metric_'.$tf} =  $tforecast['fcttext_metric'];
    ${'tf_rain_prob_'.$tf} =  $tforecast['pop'];
}

$simpleforecast = $forecast_array['forecast']['simpleforecast']['forecastday'];
$sf_count = count($simpleforecast);
for($sf = 0; $sf < $sf_count; $sf++)
{
    $sforecast = $simpleforecast[$sf];
    // Forecast Date
    ${'sf_date_epoch_'.$sf} = $sforecast['date']['epoch'];
    ${'sf_date_pretty_'.$sf} = $sforecast['date']['pretty'];
    ${'sf_date_day_'.$sf} = $sforecast['date']['day'];
    ${'sf_date_month_'.$sf} = $sforecast['date']['month'];
    ${'sf_date_year_'.$sf} = $sforecast['date']['year'];
    ${'sf_date_yday_'.$sf} = $sforecast['date']['yday'];
    ${'sf_date_hour_'.$sf} = $sforecast['date']['hour'];
    ${'sf_date_min_'.$sf} = $sforecast['date']['min'];
    ${'sf_date_monthname_'.$sf} = $sforecast['date']['monthname'];
    ${'sf_date_monthname_short_'.$sf} = $sforecast['date']['monthname_short'];
    ${'sf_date_weekday_'.$sf} = $sforecast['date']['weekday'];
    ${'sf_date_weekenday_short_'.$sf} = $sforecast['date']['weekday_short'];
    ${'sf_date_ampm_'.$sf} = $sforecast['date']['ampm'];
    ${'sf_date_tz_short_'.$sf} = $sforecast['date']['tz_short'];
    ${'sf_date_tz_long_'.$sf} = $sforecast['date']['tz_long'];

    // Forecast Temperature
    ${'sf_high_f_'.$sf} = $sforecast['high']['fahrenheit'];
    ${'sf_high_c_'.$sf} = $sforecast['high']['celsius'];
    ${'sf_low_f_'.$sf} = $sforecast['low']['fahrenheit'];
    ${'sf_low_c_'.$sf} = $sforecast['low']['celsius'];

    // Forecast Conditions
    ${'sf_conditions_'.$sf} = $sforecast['conditions'];
    ${'sf_icon_'.$sf} = $sforecast['icon'];
    ${'sf_icon_url_'.$sf} = $sforecast['icon_url'];
    ${'sf_skyicon_'.$sf} = $sforecast['skyicon'];
    ${'sf_rain_allday_in_'.$sf} = $sforecast['qpf_allday']['in'];
    ${'sf_rain_allday_mm_'.$sf} = $sforecast['qpf_allday']['mm'];
    ${'sf_rain_day_in_'.$sf} = $sforecast['qpf_day']['in'];
    ${'sf_rain_day_mm_'.$sf} = $sforecast['qpf_day']['mm'];
    ${'sf_rain_night_in_'.$sf} = $sforecast['qpf_night']['in'];
    ${'sf_rain_night_mm_'.$sf} = $sforecast['qpf_night']['mm'];
    ${'sf_snow_allday_in_'.$sf} = $sforecast['snow_allday']['in'];
    ${'sf_snow_allday_mm_'.$sf} = $sforecast['snow_allday']['cm'];
    ${'sf_snow_day_in_'.$sf} = $sforecast['snow_day']['in'];
    ${'sf_snow_day_mm_'.$sf} = $sforecast['snow_day']['cm'];
    ${'sf_snow_night_in_'.$sf} = $sforecast['snow_night']['in'];
    ${'sf_snow_night_mm_'.$sf} = $sforecast['snow_night']['cm'];
    ${'sf_maxwind_mph_'.$sf} = $sforecast['maxwind']['mph'];
    ${'sf_maxwind_kph_'.$sf} = $sforecast['maxwind']['kph'];
    ${'sf_maxwind_dir_'.$sf} = $sforecast['maxwind']['dir'];
    ${'sf_maxwind_degrees_'.$sf} = $sforecast['maxwind']['degrees'];
    ${'sf_average_wind_mph_'.$sf} = $sforecast['avewind']['mph'];
    ${'sf_average_wind_kph_'.$sf} = $sforecast['avewind']['kph'];
    ${'sf_average_wind_dir_'.$sf} = $sforecast['avewind']['dir'];
    ${'sf_average_wind_degrees_'.$sf} = $sforecast['avewind']['degrees'];
    ${'sf_humidity_average_'.$sf} = $sforecast['avehumidity'];
    ${'sf_humidity_max_'.$sf} = $sforecast['maxhumidity'];
    ${'sf_humidity_min_'.$sf} = $sforecast['minhumidity'];
}

// Get Weather Alerts

$weather_alert_json = file_get_contents('http://api.wunderground.com/api/'.$api_key.'/alerts/q/'.$api_state.'/'.$api_city.'.json');
$weather_array = json_decode($weather_alert_json, true);

$weather_alerts = $weather_array['alerts'];
$wac = count($weather_alerts);

for($a = 0; $a < $wac; $a++)
{
    $wa = $weather_alerts[$a];
    ${'wa_type_'.$a} = $wa['type'];
    if (${'wa_type_'.$a} == 'HUR') {
        ${'wa_type_'.$a} = 'Hurricane Local Statement: ';
    }
    elseif (${'wa_type_'.$a} == 'TOR') {
        ${'wa_type_'.$a} = 'Tornado Warning: ';
    }
    elseif (${'wa_type_'.$a} == 'TOW') {
        ${'wa_type_'.$a} = 'Tornado Watch: ';
    }
    elseif (${'wa_type_'.$a} == 'WRN') {
        ${'wa_type_'.$a} = 'Severe Thunderstorm Warning: ';
    }
    elseif (${'wa_type_'.$a} == 'SEW') {
        ${'wa_type_'.$a} = 'Severe Thunderstorm Watch: ';
    }
    elseif (${'wa_type_'.$a} == 'WIN') {
        ${'wa_type_'.$a} = 'Winter Weather Advisory: ';
    }
    elseif (${'wa_type_'.$a} == 'FLO') {
        ${'wa_type_'.$a} = 'Flood Warning: ';
    }
    elseif (${'wa_type_'.$a} == 'WAT') {
        ${'wa_type_'.$a} = 'Flood Watch / Statement: ';
    }
    elseif (${'wa_type_'.$a} == 'WND') {
        ${'wa_type_'.$a} = 'High Wind Advisory: ';
    }
    elseif (${'wa_type_'.$a} == 'SVR') {
        ${'wa_type_'.$a} = 'Severe Weather Statement: ';
    }
    elseif (${'wa_type_'.$a} == 'HEA') {
        ${'wa_type_'.$a} = 'Heat Advisory: ';
    }
    elseif (${'wa_type_'.$a} == 'FOG') {
        ${'wa_type_'.$a} = 'Dense Fog Advisory: ';
    }
    elseif (${'wa_type_'.$a} == 'SPE') {
        ${'wa_type_'.$a} = 'Special Weather Statement: ';
    }
    elseif (${'wa_type_'.$a} == 'FIR') {
        ${'wa_type_'.$a} = 'Fire Weather Advisory: ';
    }
    elseif (${'wa_type_'.$a} == 'VOL') {
        ${'wa_type_'.$a} = 'Volcanic Activity Statement: ';
    }
    elseif (${'wa_type_'.$a} == 'HWW') {
        ${'wa_type_'.$a} = 'Hurricane Wind Warning: ';
    }
    elseif (${'wa_type_'.$a} == 'REC') {
        ${'wa_type_'.$a} = 'Record Set: ';
    }
    elseif (${'wa_type_'.$a} == 'REP') {
        ${'wa_type_'.$a} = 'Public Reports: ';
    }
    elseif (${'wa_type_'.$a} == 'PUB') {
        ${'wa_type_'.$a} = 'Public Information Statement: ';
    }
    ${'wa_description_'.$a} = $wa['description'];
    ${'wa_date_'.$a} =  $wa['date'];
    ${'wa_expires_'.$a} =  $wa['expires'];
    ${'wa_message_'.$a} =  $wa['message'];
}

// Show animated radar
$animated_radar_url = 'http://api.wunderground.com/api/'.$api_key.'/animatedradar/q/'.$api_state.'/'.$api_city.'.gif?newmaps=1&timelabel=1&timelabel.y=10&num=15&delay=10&smooth=1&width=500&height=300&radius=10';

?>