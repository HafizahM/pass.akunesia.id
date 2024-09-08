<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_item WHERE item_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

// Delete from tbl_item
$statement = $pdo->prepare("DELETE FROM tbl_item WHERE item_id=?");
$statement->execute(array($_REQUEST['id']));

// Delete from tbl_item_user
$statement = $pdo->prepare("DELETE FROM tbl_item_user WHERE item_id=?");
$statement->execute(array($_REQUEST['id']));

// Delete from tbl_item_group
$statement = $pdo->prepare("DELETE FROM tbl_item_group WHERE item_id=?");
$statement->execute(array($_REQUEST['id']));

header('location: item.php');
?>