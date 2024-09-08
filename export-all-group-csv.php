<?php
include 'inc/config.php';
include 'inc/functions.php';
$now = 'date_';
$now .= date("Y_m_d");
$now .= '_time_';
$now .= date("h_i_s_a");

header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename='.$now.'_all_group.csv');  
$output = fopen("php://output", "w");  
fputcsv($output, array(
			'SL',
			'Group Name',
			'Group Status',
			'Users (under this group)'
		));
$i=0;
$q = $pdo->prepare("
            SELECT * 
            FROM tbl_group
        ");
$q->execute();
$res = $q->fetchAll();
foreach ($res as $row) {
	$i++;

	$str1 = '';
	$j=0;
	$r = $pdo->prepare("SELECT *
	                FROM tbl_user_group t1
	                JOIN tbl_user t2
	                ON t1.user_id = t2.id 
	                WHERE t1.group_id=?");
	$r->execute(array($row['group_id']));
	$result1 = $r->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result1 as $row1) {
		$j++;
		if($j==1) {
		    $str1 .= $j.'. '.$row1['fname'].' '.$row1['lname'];
		} else {
		    $str1 .= ', '.$j.'. '.$row1['fname'].' '.$row1['lname'];
		}
	}

	fputcsv($output, array(
		$i,
		$row['group_name'],
		$row['group_status'],
		$str1
	));
}
fclose($output);
?>