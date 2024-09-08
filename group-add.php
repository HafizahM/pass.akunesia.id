<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
if(isset($_POST['form1'])) {
    
    $valid = 1;

    if(empty($_POST['group_name'])) {
        $valid = 0;
        $error_message .= "Group Name can not be empty<br>";
    } else {
        // Duplicate Category checking
        $statement = $pdo->prepare("SELECT * FROM tbl_group WHERE group_name=?");
        $statement->execute(array($_POST['group_name']));
        $total = $statement->rowCount();
        if($total)
        {
            $valid = 0;
            $error_message .= "Group Name already exists<br>";
        }
    }

    if($valid == 1) {

        $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_group'");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row) {$ai_id=$row[10];}

        $statement = $pdo->prepare("INSERT INTO tbl_group (group_name,group_status) VALUES (?,?)");
        $statement->execute(array($_POST['group_name'],$_POST['group_status']));

        if(isset($_POST['user_ids'])) {
            foreach($_POST['user_ids'] as $val) {
                $statement = $pdo->prepare("INSERT INTO tbl_user_group (user_id,group_id) VALUES (?,?)");
                $statement->execute(array($val,$ai_id));
            }
        }
        $success_message = 'Group is added successfully.';

        unset($_POST['group_name']);
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Group</h1>
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
								<input type="text" class="form-control" name="group_name" maxlength="255" autocomplete="off" value="<?php if(isset($_POST['group_name'])) {echo $_POST['group_name'];} ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Group Status <span>*</span></label>
							<div class="col-sm-4">
								<select name="group_status" class="form-control select2">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Select Users </label>
							<div class="col-sm-4">
								<select name="user_ids[]" class="form-control select2" multiple>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id!=1 ORDER BY username ASC");
                                    $statement->execute();
                                    $total = $statement->rowCount();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
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