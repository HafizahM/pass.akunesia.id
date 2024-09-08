<?php
include 'inc/config.php';
include 'inc/functions.php';
$now = 'date_';
$now .= date("Y_m_d");
$now .= '_time_';
$now .= date("h_i_s_a");

header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename='.$now.'_all_user.csv');  
$output = fopen("php://output", "w");  
fputcsv($output, array(
			'SL',
			'First Name',
			'Last Name',
			'Username',
			'Email Address',
			'Phone',
			'Role',
			'Status'
		));
$i=0;
$q = $pdo->prepare("
            SELECT * 
            FROM tbl_user
        ");
$q->execute();
$res = $q->fetchAll();
foreach ($res as $row) {
	$i++;
	fputcsv($output, array(
		$i,
		$row['fname'],
		$row['lname'],
		$row['username'],
		$row['email'],
		$row['phone'],
		$row['role'],
		$row['status']
	));
}
fclose($output);
?>