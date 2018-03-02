<?php

require('common.php');

$action = isset($_GET['action']) ? $_GET['action']: "";

if($action=='add_kodi'){ //if the user clicked ok, run our delete query

    $query = "INSERT INTO devices SET device_name='kodi', device_location=:dl, device_ip=:di, device_port=:dp, device_username=:du, device_password=:dpw";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":dl", $_POST['device_location']);
    $stmt->bindParam(":di", $_POST['device_ip']);
    $stmt->bindParam(":dp", $_POST['device_port']);
    $stmt->bindParam(":du", $_POST['device_username']);
    $stmt->bindParam(":dpw", $_POST['device_password']);
    $result = $stmt->execute();

}

?>