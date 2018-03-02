<?php

include("common.php");

$location = $_GET['loc'];

$query = $conn->prepare('SELECT * FROM devices WHERE device_name="kodi" AND device_location="' . $location . '"');
$query->execute();
$kodi_device = $query->fetch();

$kodi_ip = $kodi_device['device_ip'];
$kodi_port = $kodi_device['device_port'];

$kodi_playertype_json = file_get_contents('http://' . $kodi_ip . ':' . $kodi_port . '/jsonrpc?request={%22jsonrpc%22:%20%222.0%22,%20%22method%22:%20%22Player.GetActivePlayers%22,%20%22id%22:%201}');
$kodi_playertype_data = json_decode($kodi_playertype_json, true);

if ($kodi_playertype_data['result'] != NULL) {
    $kodi_playertype = $kodi_playertype_data['result']['0']['type'];
    $k_active = 1;
}
else {
    $kodi_playertype = '';
    $k_active = 0;
    echo '<div style="width: 100%;">Currently Not Playing</div>';
}

if ($kodi_playertype == 'video') {
    $kodi_video_json = file_get_contents('http://' . $kodi_ip . ':' . $kodi_port . '/jsonrpc?request={"jsonrpc":%20"2.0",%20"method":%20"Player.GetItem",%20"params":%20{%20"properties":%20["title",%20"genre",%20"year",%20"rating",%20"playcount",%20"fanart",%20"director",%20"trailer",%20"tagline",%20"plot",%20"plotoutline",%20"originaltitle",%20"lastplayed",%20"writer",%20"studio",%20"mpaa",%20"cast",%20"country",%20"imdbnumber",%20"premiered",%20"runtime",%20"streamdetails",%20"votes",%20"thumbnail",%20"tag",%20"art",%20"sorttitle",%20"dateadded",%20"season",%20"episode"],%20"playerid":%201%20},%20"id":%20"VideoGetItem"}');
    $kodi_video_data = json_decode($kodi_video_json, true);

    $k_image_pre = $kodi_video_data['result']['item']['thumbnail'];
    $k_image = str_replace('image://','', urldecode($k_image_pre));

    $k_title = $kodi_video_data['result']['item']['title'];
    $k_rating = $kodi_video_data['result']['item']['mpaa'];
    $k_season = $kodi_video_data['result']['item']['season'];
    $k_episode = $kodi_video_data['result']['item']['episode'];
    $k_plot = $kodi_video_data['result']['item']['plot'];
    $k_runtime_sec =  $kodi_video_data['result']['item']['runtime'];
    $k_runtime = gmdate("H:i:s", $k_runtime_sec);



    echo '<div style="width: 40%; float: left;">
            <img src="'.$k_image.'" width="100%">
          </div>
          <div style="width: 55%; float: right; padding-left: 5px">
            <b>Movie Title: </b>' . $k_title . '<br>
            <b>Season: </b>' . $k_season . '<br>
            <b>Rating: </b>' . $k_rating . '<br>
            <b>Runtime: </b>' . $k_runtime . '<br>
            <b>Plot: </b>' . $k_plot . '
          </div>';


}
elseif ($kodi_playertype == 'audio') {
    // AUDIO DATA
    $kodi_audio_json = file_get_contents('http://' . $kodi_ip . ':' . $kodi_port . '/jsonrpc?request={"jsonrpc":');
}
elseif ($kodi_playertype == '') {
    // If playertype is '' then nothing is playing so we do nothing.
}

?>

