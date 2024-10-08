<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['category_name'])) {
        $valid = 0;
        $error_message .= "Category Name can not be empty\\n";
    } else {
        // Duplicate Category checking
        // current category name that is in the database
        $statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_id=?");
        $statement->execute(array($_REQUEST['id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $current_category_name = $row['category_name'];
        }

        $statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_name=? and category_name!=?");
        $statement->execute(array($_POST['category_name'],$current_category_name));
        $total = $statement->rowCount();                            
        if($total) {
            $valid = 0;
            $error_message .= 'Category name already exists\\n';
        }
    }

    if($valid == 1) {

        // updating into the database
        $statement = $pdo->prepare("UPDATE tbl_category SET category_name=? WHERE category_id=?");
        $statement->execute(array($_POST['category_name'],$_REQUEST['id']));

        $success_message = 'Category is updated successfully.';
    }
}
?>

<?php
if(!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if( $total == 0 ) {
        header('location: logout.php');
        exit;
    }
}
?>

<?php                           
foreach ($result as $row) {
    $category_name = $row['category_name'];
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Category</h1>
	</div>
	<div class="content-header-right">
		<a href="category.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<section class="content">

  	<div class="row">
	    <div class="col-md-12">

			<?php if($error_message): ?>
			<div class="callout callout-danger">
			<p>
			<?php echo $error_message; ?>
			</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
			<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

	        <form class="form-horizontal" action="" method="post">

	        <div class="box box-info">

	            <div class="box-body">
	                <div class="form-group">
	                    <label for="" class="col-sm-2 control-label">Category Name <span>*</span></label>
	                    <div class="col-sm-4">
	                        <input type="text" class="form-control" name="category_name" maxlength="255" autocomplete="off" value="<?php echo $category_name; ?>">
	                    </div>
	                </div>
	                <div class="form-group">
	                	<label for="" class="col-sm-2 control-label"></label>
	                    <div class="col-sm-6">
	                      <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
	                    </div>
	                </div>

	            </div>

	        </div>

	        </form>

	    </div>
  	</div>

</section>

<?php require_once('footer.php'); ?>