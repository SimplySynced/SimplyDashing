<?php
require("common.php");
//require("db_connect.php");
$csv_path = 'openhab_items.xml';

$xml_url= 'http://10.1.1.40:8080/rest/items/';

//
$xml_data = file_get_contents($xml_url) or die('Not valid url !!!');
$current = $xml_data;
file_put_contents($csv_path, $current) or die('Can not open file or file not found !!!');
echo 'Data downloaded successfully !<br>';

$xml = simplexml_load_file($csv_path);
$root_name = $xml->getName();
$xml_array = xml2array($xml_url);
//print_r ($xml_array);exit;
$items = array();
$keys = array_keys($xml_array[$root_name]['item']);
if ($keys[0] == '0') {
    $items = $xml_array[$root_name]['item'];
} else {
    $items[] = $xml_array[$root_name]['item'];
}
// item info
//print_r ($items);
$items_array = array();
$i = 0;
foreach($items as $it) {
    $itemdata = array();
    $itemdata['type'] = $it['type'];
    $itemdata['name'] = $it['name'];
    $itemdata['state'] = $it['state'];
    $itemdata['link'] = $it['link'];
    $items_array[$i] = $itemdata;
    $i++;
}
//var_dump ($items_array);

$insert_sql = '';
$update_sql = '';
foreach ($items_array as $item) {
    $i = 0;
    $insert_field_str = ''; $insert_val_str = ''; $update_str = '';
    foreach ($item as $key=>$val) {
        if ($i == 0) $insert_field_str .= $key.',';
        if (is_numeric($val)) {
            $insert_val_str .= $val.',';
            $update_str .= $key."=".$val.",";
        } else {
            $insert_val_str .= "'".$val."',";
            $update_str .= $key."='".$val."',";
        }
    }
    $insert_field_str = substr($insert_field_str, 0, -1);
    $insert_val_str = substr($insert_val_str, 0, -1);
    $update_str = substr($update_str, 0, -1);
    //echo $item['name'];
    $item_id = existItem($item['name']);
    if ($item_id !== false) {
        if ($item_id == 0) {
            $insert_sql = 'INSERT INTO openhab_items SET type = :type, name = :name, state = :state, link = :link';
            $stmt = $conn->prepare($insert_sql);
            $stmt->bindParam(":type", $item['type']);
            $stmt->bindParam(":name", $item['name']);
            $stmt->bindParam(":state", $item['state']);
            $stmt->bindParam(":link", $item['link']);
            $stmt->execute();
        } else if ($item_id > 0){
            $update_sql = 'UPDATE openhab_items SET type = :type, name = :name, state = :state, link = :link WHERE id = '.$item_id;
            $stmt = $conn->prepare($update_sql);
            $stmt->bindParam(":type", $item['type']);
            $stmt->bindParam(":name", $item['name']);
            $stmt->bindParam(":state", $item['state']);
            $stmt->bindParam(":link", $item['link']);
            $stmt->execute();
        }
    }
    $i++;
}

echo 'Data insert/update successfully !<br>';

// detect if update or insert game info
// return game id
function existItem($name) {
    global $conn;
    if (empty($name)) {
        return false;
    }
    $checkItem = "SELECT id
				FROM openhab_items
				WHERE name = :name";
    $stmt = $conn->prepare($checkItem);
    $stmt->bindValue(":name", $name, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();

    //var_dump( $result );
    //echo $result['id'];

    if ($result > 0) {
        echo $result['id'];
        echo '<br>';
        return $result['id'];
    }else{
        //echo 'NO RESULT';
        return 0;
    }
}

function xml2array($url, $get_attributes = 1, $priority = 'tag') {
    $contents = "";
    if (!function_exists('xml_parser_create')) {
        return array ();
    }
    $parser = xml_parser_create('');
    if (!($fp = @ fopen($url, 'rb'))){
        return array ();
    }
    while (!feof($fp)){
        $contents .= fread($fp, 8192);
    }
    fclose($fp);
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);
    if (!$xml_values) return;
    $xml_array = array ();
        $current = & $xml_array;
    $repeated_tag_index = array ();
    foreach ($xml_values as $data) {
        unset ($attributes, $value);
        extract($data);
        $result = array ();
        $attributes_data = array ();
        if (isset ($value)){
            if ($priority == 'tag')
                $result = $value;
            else
                $result['value'] = $value;
        }
        if (isset ($attributes) and $get_attributes) {
            foreach ($attributes as $attr => $val){
                if ($priority == 'tag')
                    $attributes_data[$attr] = $val;
                else
                    $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }
        if ($type == "open") {
            $parent[$level -1] = & $current;
            if (!is_array($current) or (!in_array($tag, array_keys($current)))){
                $current[$tag] = $result;
                if ($attributes_data)
                    $current[$tag . '_attr'] = $attributes_data;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                $current = & $current[$tag];
            } else {
                if (isset ($current[$tag][0])){
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    $repeated_tag_index[$tag . '_' . $level]++;
                } else {
                    $current[$tag] = array (
                        $current[$tag],
                        $result
                    );
                    $repeated_tag_index[$tag . '_' . $level] = 2;
                    if (isset ($current[$tag . '_attr'])) {
                        $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                        unset ($current[$tag . '_attr']);
                    }
                }
                $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
                $current = & $current[$tag][$last_item_index];
            }
        } elseif ($type == "complete") {
            if (!isset ($current[$tag])) {
                $current[$tag] = $result;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                if ($priority == 'tag' and $attributes_data)
                    $current[$tag . '_attr'] = $attributes_data;
            } else {
                if (isset ($current[$tag][0]) and is_array($current[$tag])) {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    if ($priority == 'tag' and $get_attributes and $attributes_data) {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag . '_' . $level]++;
                } else {
                    $current[$tag] = array (
                        $current[$tag],
                        $result
                    );
                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    if ($priority == 'tag' and $get_attributes){
                        if (isset ($current[$tag . '_attr'])){
                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset ($current[$tag . '_attr']);
                        }
                        if ($attributes_data){
                            $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
                }
            }
        } elseif ($type == 'close') {
            $current = & $parent[$level -1];
        }
    }
    return ($xml_array);
}
?>
