<?php
include_once('includes/crud.php');
$db = new Database();
$db->connect();
include_once('includes/custom-functions.php');
include_once('includes/functions.php');
$fn = new custom_functions;

if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
    $from_date = $db->escapeString($fn->xss_clean($_POST['from_date']));
    $to_date = $db->escapeString($fn->xss_clean($_POST['to_date']));

		$sql_query = "SELECT p.id AS id,p.shop_name,p.email,p.mobile,p.address,p.latitude,p.longitude,p.datetime,u.name AS user_name,u.mobile AS user_mobile   FROM `users` u,`pharmacy_networks` p WHERE u.id=p.user_id AND DATE(p.datetime) BETWEEN '$from_date' AND '$to_date'";
		$db->sql($sql_query);
		$developer_records = $db->getResult();

		
		$filename = "Pharmacy Networks-data".date('Y-m-d') . ".xls";			
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$filename\"");	
		$show_coloumn = false;
		if(!empty($developer_records)) {
			foreach($developer_records as $record) {
				if(!$show_coloumn) {
				// display field/column names in first row
				echo implode("\t", array_keys($record)) . "\n";
				$show_coloumn = true;
				}
				echo implode("\t", array_values($record)) . "\n";
			}
		}
		exit;  
}
	
?>

