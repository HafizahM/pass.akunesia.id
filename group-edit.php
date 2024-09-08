<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	if(empty($_POST['group_name'])) {
		$valid = 0;
		$error_message .= "Group Name can not be empty<br>";
	} else {
		$statement = $pdo->prepare("SELECT * FROM tbl_group WHERE group_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_group_name = $row['group_name'];
		}

		$statement = $pdo->prepare("SELECT * FROM tbl_group WHERE group_name=? and group_name!=?");
		$statement->execute(array($_POST['group_name'],$current_group_name));
		$total = $statement->rowCount();
		if($total) {
			$valid = 0;
			$error_message .= 'Group Name already exists<br>';
		}
	}

	if($valid == 1) {

		$statement = $pdo->prepare("UPDATE tbl_group SET group_name=?, group_status=? WHERE group_id=?");
		$statement->execute(array($_POST['group_name'],$_POST['group_status'],$_REQUEST['id']));

		if(isset($_POST['user_ids'])) {
			foreach($_POST['user_ids'] as $val) {
				$statement = $pdo->prepare("INSERT INTO tbl_user_group (user_id,group_id) VALUES (?,?)");
				$statement->execute(array($val,$_REQUEST['id']));
			}
		}
		$success_message = 'Group Data is updated successfully.';
	}
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_group WHERE group_id=?");
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
	$group_name = $row['group_name'];
	$group_status = $row['group_status'];
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Group</h1>
	</div>
	<div class="content-header-right">
		<a href="group.php" class="btn btn-primary btn-sm">View All</a>
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
							<label for="" class="col-sm-2 control-label">Group Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="group_name" maxlength="255" autocomplete="off" value="<?php echo $group_name; ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Group Status <span>*</span></label>
							<div class="col-sm-4">
								<select name="group_status" class="form-control select2">
	                                <option value="Active" <?php if($group_status == 'Active') {echo 'selected';} ?>>Active</option>
	                                <option value="Inactive" <?php if($group_status == 'Inactive') {echo 'selected';} ?>>Inactive</option>
	                            </select>
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Existing Users</label>
							<div class="col-sm-4">
								<table class="table table-bordered show-data-with-delete">
                                    <?php
                                    $arr_existing_users = array();
                                    $statement = $pdo->prepare("SELECT * 
                                                                FROM tbl_user_group t1
                                                                JOIN tbl_user t2
                                                                ON t1.user_id = t2.id
                                                                WHERE t1.group_id=?");
                                    $statement->execute(array($_REQUEST['id']));
                                    $total = $statement->rowCount();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    if($total) {
                                        foreach ($result as $row) {
                                            $arr_existing_users[] = $row['user_id'];
                                            ?>
                                            <tr>
                                                <td style="padding-top:10px;"><?php echo $row['fname'].' '.$row['lname']; ?></td>
                                                <td style="width:100px;">
                                                    <a href="group-user-delete.php?id=<?php echo $row['user_id']; ?>&id1=<?php echo $_REQUEST['id']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td style="color: red;">No User Found</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Select Users</label>
							<div class="col-sm-4">
								<select name="user_ids[]" class="form-control select2" multiple>
		                            <?php
		                            $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id!=1 ORDER BY username ASC");
		                            $statement->execute();
		                            $total = $statement->rowCount();
		                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
		                            foreach ($result as $row) {
		                                if(in_array($row['id'],$arr_existing_users)) {continue;}
			                            ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['fname'].' '.$row['lname']; ?></option>
			                            <?php
		                            }
		                            ?>
                                </select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>