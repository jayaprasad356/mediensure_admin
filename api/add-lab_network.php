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
include_once('../includes/custom-functions.php');
include_once('../includes/functions.php');
$fn = new custom_functions;


if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['center_name'])) {
    $response['success'] = false;
    $response['message'] = "Center Name is Empty";
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
if (empty($_POST['manager_name'])) {
    $response['success'] = false;
    $response['message'] = "Manager Or Head Name is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['center_address'])) {
    $response['success'] = false;
    $response['message'] = "Center Address is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['operational_hours'])) {
    $response['success'] = false;
    $response['message'] = "Operational Hours is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['radiology_test'])) {
    $response['success'] = false;
    $response['message'] = "Radiology Test is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['home_visit'])) {
    $response['success'] = false;
    $response['message'] = "Home Visit is Empty";
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

$user_id = $db->escapeString($_POST['user_id']);
$center_name = $db->escapeString($_POST['center_name']);
$mobile = $db->escapeString($_POST['mobile']);
$email = $db->escapeString($_POST['email']);
$manager_name = $db->escapeString($_POST['manager_name']);
$center_address = $db->escapeString($_POST['center_address']);
$operational_hours = $db->escapeString($_POST['operational_hours']);
$radiology_test = $db->escapeString($_POST['radiology_test']);
$home_visit = $db->escapeString($_POST['home_visit']);
$latitude = $db->escapeString($_POST['latitude']);
$longitude = $db->escapeString($_POST['longitude']);
$datetime=date('Y-m-d H:i:s');

// $sql = "SELECT * FROM lab_networks WHERE center_name = '$center_name' AND email='$email'";
// $db->sql($sql);
// $res = $db->getResult();
// $num = $db->numRows($res);
// if ($num >= 1) {
//     $response['success'] = false;
//     $response['message'] ="Lab Network Already Exists";
//     print_r(json_encode($response));
//     return false;
// }
// else{
    if (isset($_FILES['image']) && !empty($_FILES['image']) && $_FILES['image']['error'] == 0 && $_FILES['image']['size'] > 0) {
        if (!is_dir('../upload/images/')) {
            mkdir('../upload/images/', 0777, true);
        }
        $image = $db->escapeString($fn->xss_clean($_FILES['image']['name']));
        $extension = pathinfo($_FILES["image"]["name"])['extension'];
        $result = $fn->validate_image($_FILES["image"]);
        if (!$result) {
            $response["success"]   = false;
            $response["message"] = "Image type must jpg, jpeg, gif, or png!";
            print_r(json_encode($response));
            return false;
        }
        $filename = microtime(true) . '.' . strtolower($extension);
        $full_path = '../upload/images/' . "" . $filename;
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)) {
            $response["success"]   = false;
            $response["message"] = "Invalid directory to load image!";
            print_r(json_encode($response));
            return false;
        }
    }

    $sql = "INSERT INTO lab_networks (`user_id`,`center_name`,`mobile`,`email`,`manager_name`,`center_address`,`operational_hours`,`radiology_test`,`home_visit`,`latitude`,`longitude`,`image`,`datetime`) VALUES ('$user_id','$center_name','$mobile','$email','$manager_name','$center_address','$operational_hours','$radiology_test','$home_visit','$latitude','$longitude','$filename','$datetime')";
    $db->sql($sql);
    $sql = "SELECT * FROM lab_networks WHERE center_name = '$center_name' AND email='$email'";
    $db->sql($sql);
    $res = $db->getResult();
    $response['success'] = true;
    $response['message'] = "Lab Invetory Added Successfully";
    $response['data'] = $res;
    print_r(json_encode($response));

// }

?>