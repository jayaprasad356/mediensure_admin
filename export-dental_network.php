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

		$sql_query = "SELECT d.id AS id,d.clinic_name,d.email,d.mobile,d.address,d.datetime,d.latitude,d.longitude,u.name AS user_name,u.mobile AS user_mobile  FROM `users` u,`dental_networks` d WHERE u.id=d.user_id AND DATE(d.datetime) BETWEEN '$from_date' AND '$to_date'";
		$db->sql($sql_query);
		$developer_records = $db->getResult();

		
		$filename = "Dental Networks-data".date('Y-m-d') . ".xls";			
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

