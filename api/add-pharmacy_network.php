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
$shop_name = $db->escapeString($_POST['shop_name']);
$mobile = $db->escapeString($_POST['mobile']);
$email = $db->escapeString($_POST['email']);
$address = $db->escapeString($_POST['address']);
$operational_hours = $db->escapeString($_POST['operational_hours']);
$latitude = $db->escapeString($_POST['latitude']);
$longitude = $db->escapeString($_POST['longitude']);
$datetime=date('Y-m-d H:i:s');

// $sql = "SELECT * FROM pharmacy_networks WHERE shop_name = '$shop_name' AND mobile='$mobile'";
// $db->sql($sql);
// $res = $db->getResult();
// $num = $db->numRows($res);
// if ($num >= 1) {
//     $response['success'] = false;
//     $response['message'] ="Pharmacy Network Already Exists";
//     print_r(json_encode($response));
//     return false;
// }
// else{
  
    $sql = "INSERT INTO pharmacy_networks (`user_id`,`shop_name`,`mobile`,`email`,`address`,`operational_hours`,`latitude`,`longitude`,`datetime`) VALUES ('$user_id','$shop_name','$mobile','$email','$address','$operational_hours','$latitude','$longitude','$datetime')";
    $db->sql($sql);
    $sql = "SELECT * FROM pharmacy_networks WHERE shop_name = '$shop_name' AND mobile='$mobile'";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Pharmacy Invetory Added Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));

// }

?>