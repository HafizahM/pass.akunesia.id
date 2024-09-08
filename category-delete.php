<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
	
	$q = $pdo->prepare("SELECT * FROM tbl_item WHERE category_id=?");
	$q->execute([$_REQUEST['id']]);
	$res = $q->fetchAll();
	foreach ($res as $row) {
		$item_id = $row['item_id'];

		$r = $pdo->prepare("DELETE FROM tbl_item WHERE item_id=?");
		$r->execute(array($item_id));

		$r = $pdo->prepare("DELETE FROM tbl_item_user WHERE item_id=?");
		$r->execute(array($item_id));

		$r = $pdo->prepare("DELETE FROM tbl_item_group WHERE item_id=?");
		$r->execute(array($item_id));

	}
	
	$statement = $pdo->prepare("DELETE FROM tbl_category WHERE category_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: category.php');
?>