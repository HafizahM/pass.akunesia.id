<?php
include 'inc/config.php';
include 'inc/functions.php';
$now = 'date_';
$now .= date("Y_m_d");
$now .= '_time_';
$now .= date("h_i_s_a");

header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename='.$now.'_all_items.csv');  
$output = fopen("php://output", "w");  
fputcsv($output, array(
			'SL',
			'Name',
			'URL',
			'Username',
			'Password',
			'Extra Info',
			'Category',
			'Users',
			'Groups'
		));
$i=0;
$q = $pdo->prepare("
            SELECT * 
            FROM tbl_item t1
            JOIN tbl_category t2
            ON t1.category_id = t2.category_id
            ORDER BY t1.item_id ASC
        ");
$q->execute();
$res = $q->fetchAll();
foreach ($res as $row) {
	$i++;

	$str1 = '';
	$j=0;
	$r = $pdo->prepare("SELECT *
	                FROM tbl_item_user t1
	                JOIN tbl_user t2
	                ON t1.user_id = t2.id 
	                WHERE t1.item_id=?");
	$r->execute(array($row['item_id']));
	$result1 = $r->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result1 as $row1) {
		$j++;
		if($j==1) {
		    $str1 .= $j.'. '.$row1['fname'].' '.$row1['lname'];
		} else {
		    $str1 .= ', '.$j.'. '.$row1['fname'].' '.$row1['lname'];
		}
	}

	$str2 = '';
    $j=0;
    $r = $pdo->prepare("SELECT *
                        FROM tbl_item_group t1
                        JOIN tbl_group t2
                        ON t1.group_id = t2.group_id 
                        WHERE t1.item_id=?");
    $r->execute(array($row['item_id']));
    $result1 = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result1 as $row1) {
        $j++;
        if($j==1) {
            $str2 .= $j.'. '.$row1['group_name'];
        } else {
            $str2 .= ', '.$j.'. '.$row1['group_name'];
        }
    }

	fputcsv($output, array(
		$i,
		decr($row['name'],PRIVATE_KEY),
		decr($row['url'],PRIVATE_KEY),
		decr($row['username'],PRIVATE_KEY),
		decr($row['password'],PRIVATE_KEY),
		decr($row['extra_info'],PRIVATE_KEY),
		$row['category_name'],
		$str1,
		$str2
	));
}
fclose($output);
?>