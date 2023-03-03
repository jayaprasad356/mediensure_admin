<?php
session_start();

// set time for session timeout
$currentTime = time() + 25200;
$expired = 3600;

// if session not set go to login page
if (!isset($_SESSION['username'])) {
    header("location:index.php");
}

// if current time is more than session timeout back to login page
if ($currentTime > $_SESSION['timeout']) {
    session_destroy();
    header("location:index.php");
}

// destroy previous session timeout and create new one
unset($_SESSION['timeout']);
$_SESSION['timeout'] = $currentTime + $expired;

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../includes/custom-functions.php');
$fn = new custom_functions;
include_once('../includes/crud.php');
include_once('../includes/variables.php');
$db = new Database();
$db->connect();

if (isset($config['system_timezone']) && isset($config['system_timezone_gmt'])) {
    date_default_timezone_set($config['system_timezone']);
    $db->sql("SET `time_zone` = '" . $config['system_timezone_gmt'] . "'");
} else {
    date_default_timezone_set('Asia/Kolkata');
    $db->sql("SET `time_zone` = '+05:30'");
}
if (isset($_GET['table']) && $_GET['table'] == 'users') {

    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($_GET['offset']);
    if (isset($_GET['limit']))
        $limit = $db->escapeString($_GET['limit']);
    if (isset($_GET['sort']))
        $sort = $db->escapeString($_GET['sort']);
    if (isset($_GET['order']))
        $order = $db->escapeString($_GET['order']);

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($_GET['search']);
        $where .= "WHERE name like '%" . $search . "%' OR id like '%" . $search . "%'  OR mobile like '%" . $search . "%'  OR email like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);
    }
    $sql = "SELECT COUNT(`id`) as total FROM `users` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
   
    $sql = "SELECT * FROM users " . $where . " ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . ", " . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {

        
        $operate = ' <a href="edit-user.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="btn-xs btn-danger" href="delete-user.php?id=' . $row['id'] . '"><i class="fa fa-trash-o"></i>Delete</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['email'] = $row['email'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'categories') {

    $offset = 0;
    $limit = 10;
    $sort = 'id';
    $order = 'DESC';
    $where = '';
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= "WHERE name like '%" . $search . "%' OR id like '%" . $search . "%'";
    }
    if (isset($_GET['sort'])){
        $sort = $db->escapeString($_GET['sort']);

    }
    if (isset($_GET['order'])){
        $order = $db->escapeString($_GET['order']);

    }
    $sql = "SELECT COUNT(`id`) as total FROM `categories` ";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];

    $sql = "SELECT * FROM `categories` ". $where ." ORDER BY " . $sort . " " . $order . " LIMIT " . $offset . "," . $limit;
    $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;
    
    $rows = array();
    $tempRow = array();

    foreach ($res as $row) {
        $operate = ' <a  href="edit-category.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $operate .= ' <a class="text text-danger" href="delete-category.php?id=' . $row['id'] . '"><i class="fa fa-trash"></i>Delete</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        if(!empty($row['image'])){
            $tempRow['image'] = "<a data-lightbox='category' href='" . $row['image'] . "' data-caption='" . $row['name'] . "'><img src='" . $row['image'] . "' title='" . $row['name'] . "' height='50' /></a>";

        }else{
            $tempRow['image'] = 'No Image';

        }
        // $tempRow['status'] = $row['status'];
        // if ($row['status'] == 1)
        //     $tempRow['status'] = "<p class='text text-success'> Active</p>";
        // else 
        //     $tempRow['status'] = "<p class='text text-danger'>Inactive</p>";
       $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'opd_networks') {
    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    // if (isset($_GET['date']) && !empty($_GET['date'] != '')){
    //     $date = $db->escapeString($fn->xss_clean($_GET['date']));
    //     $where .= "AND DATE(opd.datetime) = '$date' ";  
    // }
    // if (isset($_GET['year']) && !empty($_GET['year'] != '')){
    //     $year = $db->escapeString($fn->xss_clean($_GET['year']));
    //     $where .= "AND YEAR(o.order_date) = '$year' ";  
    // }
    // if (isset($_GET['month']) && !empty($_GET['month'] != '')){
    //     $month = $db->escapeString($fn->xss_clean($_GET['month']));
    //     $where .= "AND MONTH(o.order_date) = '$month' ";  
    // }
    if ((isset($_GET['from_date']) && !empty($_GET['from_date'] != '')) && (isset($_GET['to_date']) && !empty($_GET['to_date'] != ''))){
        $from_date = $db->escapeString($fn->xss_clean($_GET['from_date']));
        $to_date = $db->escapeString($fn->xss_clean($_GET['to_date']));
        $where .= "AND DATE(opd.datetime) BETWEEN '$from_date' AND '$to_date' ";  
    }
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= "AND u.name like '%" . $search . "%' OR opd.mobile like '%" . $search . "%' OR opd.name like '%" . $search . "%'  OR opd.address like '%" . $search . "%' OR opd.remarks like '%" . $search . "%' ";
    }
    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }
    $join = "LEFT JOIN `users` u ON opd.user_id = u.id WHERE opd.id IS NOT NULL ";

    $sql = "SELECT COUNT(opd.id) as total FROM `opd_networks` opd $join " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
        
    $sql = "SELECT opd.id AS id,opd.*,u.name AS name,opd.mobile AS mobile,opd.name AS clinic_name,opd.address AS address,opd.email AS email FROM `opd_networks` opd $join 
        $where ORDER BY $sort $order LIMIT $offset, $limit";
     $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();
    foreach ($res as $row) {
        
        $operate = ' <a href="edit-opd_network.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['datetime'] = $row['datetime'];
        $tempRow['clinic_name'] = $row['clinic_name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['email'] = $row['email'];
        $tempRow['address'] = $row['address'];
        $tempRow['latitude'] = $row['latitude'];
        $tempRow['longitude'] = $row['longitude'];
        $tempRow['remarks'] = $row['remarks'];
        if($row['status'] == 1)
            $tempRow['status'] = "<p class='text text-success'> Verified</p>";
        elseif($row['status'] == 2)
            $tempRow['status'] = "<p class='text text-danger'>Rejected</p>";
        else
            $tempRow['status'] = "<p class='text text-warning'>Pending</p>";
         $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}
if (isset($_GET['table']) && $_GET['table'] == 'lab_networks') {
    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    // if (isset($_GET['date']) && !empty($_GET['date'] != '')){
    //     $date = $db->escapeString($fn->xss_clean($_GET['date']));
    //     $where .= "AND DATE(l.datetime) = '$date' ";  
    // }
    // if (isset($_GET['year']) && !empty($_GET['year'] != '')){
    //     $year = $db->escapeString($fn->xss_clean($_GET['year']));
    //     $where .= "AND YEAR(o.order_date) = '$year' ";  
    // }
    // if (isset($_GET['month']) && !empty($_GET['month'] != '')){
    //     $month = $db->escapeString($fn->xss_clean($_GET['month']));
    //     $where .= "AND MONTH(o.order_date) = '$month' ";  
    // }
    if ((isset($_GET['from_date']) && !empty($_GET['from_date'] != '')) && (isset($_GET['to_date']) && !empty($_GET['to_date'] != ''))){
        $from_date = $db->escapeString($fn->xss_clean($_GET['from_date']));
        $to_date = $db->escapeString($fn->xss_clean($_GET['to_date']));
        $where .= "AND DATE(l.datetime) BETWEEN '$from_date' AND '$to_date' ";  
    }
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= "AND u.name like '%" . $search . "%' OR l.mobile like '%" . $search . "%' OR l.center_name like '%" . $search . "%' OR l.center_address like '%" . $search . "%' OR l.manager_name like '%" . $search . "%' OR l.operational_hours like '%" . $search . "%' OR l.radiology_test like '%" . $search . "%' OR l.home_visit like '%" . $search . "%' OR l.remarks like '%" . $search . "%' ";
    }
    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }
    $join = "LEFT JOIN `users` u ON l.user_id = u.id WHERE l.id IS NOT NULL ";

    $sql = "SELECT COUNT(l.id) as total FROM `lab_networks` l $join " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
        
    $sql = "SELECT l.id AS id,l.*,u.name AS name,l.mobile AS mobile,l.email AS email FROM `lab_networks` l $join 
        $where ORDER BY $sort $order LIMIT $offset, $limit";
     $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();
    foreach ($res as $row) {
        
        $operate = ' <a href="edit-lab_network.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['datetime'] = $row['datetime'];
        $tempRow['center_name'] = $row['center_name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['email'] = $row['email'];
        $tempRow['manager_name'] = $row['manager_name'];
        $tempRow['center_address'] = $row['center_address'];
        $tempRow['operational_hours'] = $row['operational_hours'];
        $tempRow['radiology_test'] = $row['radiology_test'];
        $tempRow['home_visit'] = $row['home_visit'];
        $tempRow['latitude'] = $row['latitude'];
        $tempRow['longitude'] = $row['longitude'];
        if(!empty($row['image'])){
            $tempRow['image'] = "<a data-lightbox='category' href='" . $row['image'] . "' data-caption='" . $row['name'] . "'><img src='upload/images/" . $row['image'] . "' title='" . $row['name'] . "' height='70' /></a>";

        }else{
            $tempRow['image'] = 'No Image';

        }
        $tempRow['remarks'] = $row['remarks'];
        if($row['status'] == 1)
            $tempRow['status'] = "<p class='text text-success'> Verified</p>";
        elseif($row['status'] == 2)
            $tempRow['status'] = "<p class='text text-danger'>Rejected</p>";
        else
            $tempRow['status'] = "<p class='text text-warning'>Pending</p>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'pharmacy_networks') {
    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    // if (isset($_GET['date']) && !empty($_GET['date'] != '')){
    //     $date = $db->escapeString($fn->xss_clean($_GET['date']));
    //     $where .= "AND DATE(opd.datetime)= '$date' ";  
    // }
    // if (isset($_GET['year']) && !empty($_GET['year'] != '')){
    //     $year = $db->escapeString($fn->xss_clean($_GET['year']));
    //     $where .= "AND YEAR(o.order_date) = '$year' ";  
    // }
    // if (isset($_GET['month']) && !empty($_GET['month'] != '')){
    //     $month = $db->escapeString($fn->xss_clean($_GET['month']));
    //     $where .= "AND MONTH(o.order_date) = '$month' ";  
    // }
    if ((isset($_GET['from_date']) && !empty($_GET['from_date'] != '')) && (isset($_GET['to_date']) && !empty($_GET['to_date'] != ''))){
        $from_date = $db->escapeString($fn->xss_clean($_GET['from_date']));
        $to_date = $db->escapeString($fn->xss_clean($_GET['to_date']));
        $where .= "AND DATE(opd.datetime) BETWEEN '$from_date' AND '$to_date' ";  
    }
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= "AND u.name like '%" . $search . "%' OR opd.mobile like '%" . $search . "%' OR opd.shop_name like '%" . $search . "%'  OR opd.address like '%" . $search . "%' OR opd.remarks like '%" . $search . "%' ";
    }
    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }
    $join = "LEFT JOIN `users` u ON opd.user_id = u.id WHERE opd.id IS NOT NULL ";

    $sql = "SELECT COUNT(opd.id) as total FROM `pharmacy_networks` opd $join " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
        
    $sql = "SELECT opd.id AS id,opd.*,u.name AS name,opd.mobile AS mobile,opd.shop_name,opd.address AS address,opd.email AS email FROM `pharmacy_networks` opd $join 
        $where ORDER BY $sort $order LIMIT $offset, $limit";
     $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();
    foreach ($res as $row) {
        
        $operate = ' <a href="edit-pharmacy_network.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['datetime'] = $row['datetime'];
        $tempRow['shop_name'] = $row['shop_name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['email'] = $row['email'];
        $tempRow['address'] = $row['address'];
        $tempRow['operational_hours'] = $row['operational_hours'];
        $tempRow['latitude'] = $row['latitude'];
        $tempRow['longitude'] = $row['longitude'];
        $tempRow['remarks'] = $row['remarks'];
        if($row['status'] == 1)
            $tempRow['status'] = "<p class='text text-success'> Verified</p>";
        elseif($row['status'] == 2)
            $tempRow['status'] = "<p class='text text-danger'>Rejected</p>";
        else
            $tempRow['status'] = "<p class='text text-warning'>Pending</p>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

if (isset($_GET['table']) && $_GET['table'] == 'dental_networks') {
    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    // if (isset($_GET['date']) && !empty($_GET['date'] != '')){
    //     $date = $db->escapeString($fn->xss_clean($_GET['date']));
    //     $where .= "AND DATE(d.datetime)= '$date' ";  
    // }
    // if (isset($_GET['year']) && !empty($_GET['year'] != '')){
    //     $year = $db->escapeString($fn->xss_clean($_GET['year']));
    //     $where .= "AND YEAR(o.order_date) = '$year' ";  
    // }
    // if (isset($_GET['month']) && !empty($_GET['month'] != '')){
    //     $month = $db->escapeString($fn->xss_clean($_GET['month']));
    //     $where .= "AND MONTH(o.order_date) = '$month' ";  
    // }
    if ((isset($_GET['from_date']) && !empty($_GET['from_date'] != '')) && (isset($_GET['to_date']) && !empty($_GET['to_date'] != ''))){
        $from_date = $db->escapeString($fn->xss_clean($_GET['from_date']));
        $to_date = $db->escapeString($fn->xss_clean($_GET['to_date']));
        $where .= "AND DATE(d.datetime) BETWEEN '$from_date' AND '$to_date' ";  
    }
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= "AND u.name like '%" . $search . "%' OR d.mobile like '%" . $search . "%' OR d.clinic_name like '%" . $search . "%' OR d.address like '%" . $search . "%' OR d.oral_xray like '%" . $search . "%' OR d.remarks like '%" . $search . "%' ";
    }
    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }
    $join = "LEFT JOIN `users` u ON d.user_id = u.id WHERE d.id IS NOT NULL ";

    $sql = "SELECT COUNT(d.id) as total FROM `dental_networks` d $join " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
        
    $sql = "SELECT d.id AS id,d.*,u.name AS name,d.mobile AS mobile,d.clinic_name,d.address AS address,d.email AS email FROM `dental_networks` d $join 
        $where ORDER BY $sort $order LIMIT $offset, $limit";
     $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();
    foreach ($res as $row) {
        
        $operate = ' <a href="edit-dental_network.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['datetime'] = $row['datetime'];
        $tempRow['clinic_name'] = $row['clinic_name'];
        $tempRow['oral_xray'] = $row['oral_xray'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['email'] = $row['email'];
        $tempRow['address'] = $row['address'];
        $tempRow['latitude'] = $row['latitude'];
        $tempRow['longitude'] = $row['longitude'];
        $tempRow['remarks'] = $row['remarks'];
        if($row['status'] == 1)
            $tempRow['status'] = "<p class='text text-success'> Verified</p>";
        elseif($row['status'] == 2)
            $tempRow['status'] = "<p class='text text-danger'>Rejected</p>";
        else
            $tempRow['status'] = "<p class='text text-warning'>Pending</p>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

//radiology netwoks table goes here
if (isset($_GET['table']) && $_GET['table'] == 'radiology_networks') {
    $offset = 0;
    $limit = 10;
    $where = '';
    $sort = 'id';
    $order = 'DESC';
    // if (isset($_GET['date']) && !empty($_GET['date'] != '')){
    //     $date = $db->escapeString($fn->xss_clean($_GET['date']));
    //     $where .= "AND DATE(l.datetime) = '$date' ";  
    // }
    // if (isset($_GET['year']) && !empty($_GET['year'] != '')){
    //     $year = $db->escapeString($fn->xss_clean($_GET['year']));
    //     $where .= "AND YEAR(o.order_date) = '$year' ";  
    // }
    // if (isset($_GET['month']) && !empty($_GET['month'] != '')){
    //     $month = $db->escapeString($fn->xss_clean($_GET['month']));
    //     $where .= "AND MONTH(o.order_date) = '$month' ";  
    // }
    if ((isset($_GET['from_date']) && !empty($_GET['from_date'] != '')) && (isset($_GET['to_date']) && !empty($_GET['to_date'] != ''))){
        $from_date = $db->escapeString($fn->xss_clean($_GET['from_date']));
        $to_date = $db->escapeString($fn->xss_clean($_GET['to_date']));
        $where .= "AND DATE(r.datetime) BETWEEN '$from_date' AND '$to_date' ";  
    }
    if (isset($_GET['offset']))
        $offset = $db->escapeString($fn->xss_clean($_GET['offset']));
    if (isset($_GET['limit']))
        $limit = $db->escapeString($fn->xss_clean($_GET['limit']));

    if (isset($_GET['sort']))
        $sort = $db->escapeString($fn->xss_clean($_GET['sort']));
    if (isset($_GET['order']))
        $order = $db->escapeString($fn->xss_clean($_GET['order']));

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $db->escapeString($fn->xss_clean($_GET['search']));
        $where .= "AND u.name like '%" . $search . "%' OR r.mobile like '%" . $search . "%' OR r.center_name like '%" . $search . "%' OR r.center_address like '%" . $search . "%' OR r.manager_name like '%" . $search . "%' OR r.operational_hours like '%" . $search . "%' OR r.remarks like '%" . $search . "%' ";
    }
    if (isset($_GET['sort'])) {
        $sort = $db->escapeString($_GET['sort']);
    }
    if (isset($_GET['order'])) {
        $order = $db->escapeString($_GET['order']);
    }
    $join = "LEFT JOIN `users` u ON r.user_id = u.id WHERE r.id IS NOT NULL ";

    $sql = "SELECT COUNT(r.id) as total FROM `radiology_networks` r $join " . $where . "";
    $db->sql($sql);
    $res = $db->getResult();
    foreach ($res as $row)
        $total = $row['total'];
        
    $sql = "SELECT r.id AS id,r.*,u.name AS name,r.mobile AS mobile,r.email AS email FROM `radiology_networks` r $join 
        $where ORDER BY $sort $order LIMIT $offset, $limit";
     $db->sql($sql);
    $res = $db->getResult();

    $bulkData = array();
    $bulkData['total'] = $total;

    $rows = array();
    $tempRow = array();
    foreach ($res as $row) {
        
        $operate = ' <a href="edit-radiology_network.php?id=' . $row['id'] . '"><i class="fa fa-edit"></i>Edit</a>';
        $tempRow['id'] = $row['id'];
        $tempRow['name'] = $row['name'];
        $tempRow['datetime'] = $row['datetime'];
        $tempRow['center_name'] = $row['center_name'];
        $tempRow['mobile'] = $row['mobile'];
        $tempRow['email'] = $row['email'];
        $tempRow['manager_name'] = $row['manager_name'];
        $tempRow['center_address'] = $row['center_address'];
        $tempRow['operational_hours'] = $row['operational_hours'];
        $tempRow['latitude'] = $row['latitude'];
        $tempRow['longitude'] = $row['longitude'];
        if(!empty($row['image'])){
            $tempRow['image'] = "<a data-lightbox='category' href='" . $row['image'] . "' data-caption='" . $row['name'] . "'><img src='upload/images/" . $row['image'] . "' title='" . $row['name'] . "' height='70' /></a>";

        }else{
            $tempRow['image'] = 'No Image';

        }
        $tempRow['remarks'] = $row['remarks'];
        if($row['status'] == 1)
            $tempRow['status'] = "<p class='text text-success'> Verified</p>";
        elseif($row['status'] == 2)
            $tempRow['status'] = "<p class='text text-danger'>Rejected</p>";
        else
            $tempRow['status'] = "<p class='text text-warning'>Pending</p>";
        $tempRow['operate'] = $operate;
        $rows[] = $tempRow;
    }
    $bulkData['rows'] = $rows;
    print_r(json_encode($bulkData));
}

$db->disconnect();
