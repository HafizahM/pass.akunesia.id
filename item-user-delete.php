<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
// Preventing the direct access of this page.
if( !isset($_REQUEST['id']) || !isset($_REQUEST['id1']) ) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_item_user WHERE user_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}

$statement = $pdo->prepare("DELETE FROM tbl_item_user WHERE user_id=? AND item_id=?");
$statement->execute(array($_REQUEST['id'],$_REQUEST['id1']));

header('location: item-edit.php?id='.$_REQUEST['id1']);
?>