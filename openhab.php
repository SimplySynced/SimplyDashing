<?php
include("common.php");

$query = $conn->prepare('SELECT * FROM devices WHERE device_name="openhab"');
$query->execute();
$oh_server = $query->fetch();

// Set the ip address and port of the OpenHAB Server.
$oh_ip = $oh_server['device_ip'];
$oh_port = $oh_server['device_port'];

// Get OpenHAB JSON feed of items and current state.
$oh_json = file_get_contents('http://' . $oh_ip . ':' . $oh_port . '/rest/items');
$oh_data = json_decode($oh_json, true);
$oh_items = $oh_data['item'];

// Get count of items for loop
$oh_count = count($oh_data['item']);

// Set each item name as a variable with its current state as its value.
foreach($oh_data as $oh_item) {
    //$oh_item = $oh_items[$oh];
    ${$oh_item['name']} = $oh_item['state'];
}

?>