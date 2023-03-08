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
        SELECT user_id FROM opd_networks WHERE user_id ='$user_id' AND DATE(datetime) = '$date'
    ) AS combined_tables";
    $db->sql($sql);
    $result1 = $db->getResult();

    //Total Users Count
    $sql = "SELECT * FROM users";
    $db->sql($sql);
    $res1 = $db->getResult();
    $num1 = $db->numRows($res1);

    //Verified Users Count
    $sql = "SELECT * FROM users WHERE status=1";
    $db->sql($sql);
    $res2 = $db->getResult();
    $num2 = $db->numRows($res2);

    //Not-verified Users Count
    $sql = "SELECT * FROM users WHERE status=0";
    $db->sql($sql);
    $res3 = $db->getResult();
    $num3 = $db->numRows($res3);

    //Blocked Users Count
    $sql = "SELECT * FROM users WHERE status=2";
    $db->sql($sql);
    $res4= $db->getResult();
    $num4 = $db->numRows($res4);


    $response['success'] = true;
    $response['message'] = "User Details Successfully Retrived";
    $response['total_inventories'] =$result[0]['total_rows'];
    $response['today_inventories'] =$result1[0]['today_rows'];
    $response['total_users'] =$num1;
    $response['verified_users'] =$num2;
    $response['not_verified_users'] =$num3;
    $response['blocked_users'] =$num4;
    $response['data'] = $res;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No User Found";
    print_r(json_encode($response));

}

?>