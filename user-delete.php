<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

	// Getting photo ID to unlink from folder
	$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$photo = $row['photo'];
	}

	// Unlink the photo
	if($photo!='') {
		unlink('uploads/'.$photo);	
	}

	$statement = $pdo->prepare("DELETE FROM tbl_user_group WHERE user_id=?");
	$statement->execute(array($_REQUEST['id']));

	$statement = $pdo->prepare("DELETE FROM tbl_mail_user_all WHERE user_id=?");
	$statement->execute(array($_REQUEST['id']));

	$statement = $pdo->prepare("DELETE FROM tbl_item_user WHERE user_id=?");
	$statement->execute(array($_REQUEST['id']));

	$statement = $pdo->prepare("DELETE FROM tbl_user WHERE id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: user.php');
?>