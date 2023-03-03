<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
date_default_timezone_set('Asia/Kolkata');


include_once('../includes/crud.php');
$db = new Database();
$db->connect();


if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['inventory_id'])) {
    $response['success'] = false;
    $response['message'] = "Inventory Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['shop_name'])) {
    $response['success'] = false;
    $response['message'] = "Shop Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['mobile'])) {
    $response['success'] = false;
    $response['message'] = "Mobilenumber is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['email'])) {
    $response['success'] = false;
    $response['message'] = "Email is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['address'])) {
    $response['success'] = false;
    $response['message'] = "Address is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['latitude'])) {
    $response['success'] = false;
    $response['message'] = "Latitude is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['longitude'])) {
    $response['success'] = false;
    $response['message'] = "Longitude is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['oprational_hours'])) {
    $response['success'] = false;
    $response['message'] = "Operational Hours is Empty";
    print_r(json_encode($response));
    return false;
}

$user_id = $db->escapeString($_POST['user_id']);
$inventory_id = $db->escapeString($_POST['inventory_id']);
$shop_name = $db->escapeString($_POST['shop_name']);
$mobile = $db->escapeString($_POST['mobile']);
$email = $db->escapeString($_POST['email']);
$address = $db->escapeString($_POST['address']);
$operational_hours = $db->escapeString($_POST['operational_hours']);
$latitude = $db->escapeString($_POST['latitude']);
$longitude = $db->escapeString($_POST['longitude']);


$sql = "SELECT * FROM pharmacy_networks WHERE user_id='$user_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $sql = "UPDATE pharmacy_networks SET shop_name='$shop_name',mobile='$mobile',email='$email',address='$address',operational_hours='$operational_hours',latitude='$latitude',longitude='$longitude' WHERE id = '$inventory_id'";
    $db->sql($sql);
    $sql = "SELECT * FROM pharmacy_networks WHERE id=" . $inventory_id;
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Pharmacy Network Invetory Updated Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));
    return false;
}
else{

    $response['success'] = false;
    $response['message'] ="Inventory Not Found";
    print_r(json_encode($response));
    return false;
}

?>