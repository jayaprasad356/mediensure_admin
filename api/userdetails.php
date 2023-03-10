<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../includes/crud.php');
date_default_timezone_set('Asia/Kolkata');

$db = new Database();
$db->connect();
if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
$user_id = $db->escapeString($_POST['user_id']);
$date=date('Y-m-d');
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $sql="SELECT COUNT(*) AS total_rows FROM
    (
        SELECT user_id FROM lab_networks WHERE user_id ='$user_id'
        UNION ALL
        SELECT user_id FROM dental_networks WHERE user_id ='$user_id'
        UNION ALL
        SELECT user_id FROM pharmacy_networks WHERE user_id ='$user_id'
        UNION ALL
        SELECT user_id FROM radiology_networks WHERE user_id ='$user_id'
        UNION ALL
        SELECT user_id FROM opd_networks WHERE user_id ='$user_id'
    ) AS combined_tables";
    $db->sql($sql);
    $result = $db->getResult();


    // i want to get the today inventories count
    $sql="SELECT COUNT(*) AS today_rows FROM
    (
        SELECT user_id FROM lab_networks WHERE user_id ='$user_id' AND DATE(datetime) = '$date'
        UNION ALL
        SELECT user_id FROM dental_networks WHERE user_id ='$user_id' AND DATE(datetime) = '$date'
        UNION ALL
        SELECT user_id FROM pharmacy_networks WHERE user_id ='$user_id' AND DATE(datetime) = '$date'
        UNION ALL
        SELECT user_id FROM radiology_networks WHERE user_id ='$user_id' AND DATE(datetime) = '$date'
        UNION ALL
        SELECT user_id FROM opd_networks WHERE user_id ='$user_id' AND DATE(datetime) = '$date'
    ) AS combined_tables";
    $db->sql($sql);
    $result1 = $db->getResult();

    //Verified Networks Count
    $sql="SELECT COUNT(*) AS verified_inventories FROM
    (
        SELECT user_id FROM lab_networks WHERE user_id ='$user_id' AND status=1
        UNION ALL
        SELECT user_id FROM dental_networks WHERE user_id ='$user_id' AND status=1
        UNION ALL
        SELECT user_id FROM pharmacy_networks WHERE user_id ='$user_id' AND status=1
        UNION ALL
        SELECT user_id FROM radiology_networks WHERE user_id ='$user_id' AND status=1
        UNION ALL
        SELECT user_id FROM opd_networks WHERE user_id ='$user_id' AND status=1
    ) AS combined_tables";
    $db->sql($sql);
    $res1 = $db->getResult();

    //Pending Networks Count
    $sql="SELECT COUNT(*) AS pending_inventories FROM
    (
        SELECT user_id FROM lab_networks WHERE user_id ='$user_id' AND status=0
        UNION ALL
        SELECT user_id FROM dental_networks WHERE user_id ='$user_id' AND status=0
        UNION ALL
        SELECT user_id FROM pharmacy_networks WHERE user_id ='$user_id' AND status=0
        UNION ALL
        SELECT user_id FROM radiology_networks WHERE user_id ='$user_id' AND status=0
        UNION ALL
        SELECT user_id FROM opd_networks WHERE user_id ='$user_id' AND status=0
    ) AS combined_tables";
    $db->sql($sql);
    $res2 = $db->getResult();

    //Rejected Networks Count
    $sql="SELECT COUNT(*) AS rejected_inventories FROM
    (
        SELECT user_id FROM lab_networks WHERE user_id ='$user_id' AND status=2
        UNION ALL
        SELECT user_id FROM dental_networks WHERE user_id ='$user_id' AND status=2
        UNION ALL
        SELECT user_id FROM pharmacy_networks WHERE user_id ='$user_id' AND status=2
        UNION ALL
        SELECT user_id FROM radiology_networks WHERE user_id ='$user_id' AND status=2
        UNION ALL
        SELECT user_id FROM opd_networks WHERE user_id ='$user_id' AND status=2
    ) AS combined_tables";
    $db->sql($sql);
    $res3 = $db->getResult();


    $response['success'] = true;
    $response['message'] = "User Details Successfully Retrived";
    $response['total_inventories'] =$result[0]['total_rows'];
    $response['today_inventories'] =$result1[0]['today_rows'];
    $response['verified_inventories'] =$res1[0]['verified_inventories'];
    $response['pending_inventories'] =$res2[0]['pending_inventories'];
    $response['rejected_inventories'] =$res3[0]['rejected_inventories'];
    $response['data'] = $res;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No User Found";
    print_r(json_encode($response));

}

?>