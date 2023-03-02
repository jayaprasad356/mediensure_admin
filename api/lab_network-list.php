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

$user_id = $db->escapeString($_POST['user_id']);
$status = $db->escapeString($_POST['status']);
$sql = "SELECT * FROM lab_networks WHERE user_id = '$user_id' AND status = '$status'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    foreach($res as $row){
        $temp['id'] = $row['id'];
        $temp['center_name'] = $row['center_name'];
        $temp['email'] = $row['email'];
        $temp['mobile'] = $row['mobile'];
        $temp['manager_name'] = $row['manager_name'];
        $temp['center_address'] = $row['center_address'];
        $temp['operational_hours'] = $row['operational_hours'];
        $temp['radiology_test'] = $row['radiology_test'];
        $temp['home_visit'] = $row['home_visit'];
        $temp['latitude'] = $row['latitude'];
        $temp['longitude'] = $row['longitude'];
        $temp['datetime'] = $row['datetime'];
        $temp['image'] = DOMAIN_URL ."upload/images/" .$row['image'];
        $temp['remarks'] = $row['remarks'];
        $temp['status'] = $row['status'];
        $rows[] = $temp;
    }
    $response['success'] = true;
    $response['message'] = "LAB Networks Listed Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));
}
else{
    $response['success'] = false;
    $response['message'] = "Inventory Not Found";
    print_r(json_encode($response));
}

?>