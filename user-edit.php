<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
if(isset($_POST['form1'])) {

    $valid = 1;

    if(empty($_POST['fname'])) {
        $valid = 0;
        $error_message .= "First Name can not be empty<br>";
    }

    if(empty($_POST['lname'])) {
        $valid = 0;
        $error_message .= "Last Name can not be empty<br>";
    }

    if($valid == 1) {
        
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_user SET fname=?, lname=?, phone=?, status=? WHERE id=?");
        $statement->execute(array($_POST['fname'],$_POST['lname'],$_POST['phone'],$_POST['status'],$_REQUEST['id']));

        $success_message = 'User Information is updated successfully.';
    }
}

if(isset($_POST['form2'])) {

    $valid = 1;

    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='JPG' && $ext!='PNG' && $ext!='JPEG' && $ext!='GIF' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    }

    if($valid == 1) {

        // removing the existing photo
        $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
        $statement->execute(array($_REQUEST['id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            unlink('uploads/'.$row['photo']);
        }

        // updating the data
        $final_name = 'user-'.$_REQUEST['id'].'.'.$ext;
        move_uploaded_file( $path_tmp, 'uploads/'.$final_name );
        
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_user SET photo=? WHERE id=?");
        $statement->execute(array($final_name,$_REQUEST['id']));

        $success_message = 'User Photo is updated successfully.';
        
    }
}

if(isset($_POST['form3'])) {
    $valid = 1;

    if( empty($_POST['password']) || empty($_POST['re_password']) ) {
        $valid = 0;
        $error_message .= "Password can not be empty<br>";
    }

    if( !empty($_POST['password']) && !empty($_POST['re_password']) ) {
        if($_POST['password'] != $_POST['re_password']) {
            $valid = 0;
            $error_message .= "Passwords do not match<br>"; 
        }        
    }

    if($valid == 1) {

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_user SET password=? WHERE id=?");
        $statement->execute(array(md5($_POST['password']),$_REQUEST['id']));

        $success_message = 'User Password is updated successfully.';
    }
}
?>

<?php
if(!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if( $total == 0 || $_REQUEST['id'] == 1 ) {
        header('location: logout.php');
        exit;
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$statement->rowCount();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
foreach ($result as $row) {
    $fname = $row['fname'];
    $lname = $row['lname'];
    $username = $row['username'];
    $email = $row['email'];
    $phone = $row['phone'];
    $photo = $row['photo'];
    $status = $row['status'];
    $role = $row['role'];
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit User</h1>
	</div>
	<div class="content-header-right">
		<a href="user.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<section class="content" style="min-height:auto;margin-bottom: -30px;">
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
		</div>
	</div>
</section>

<section class="content">

	<div class="row">
		<div class="col-md-12">

				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1" data-toggle="tab">Update Information</a></li>
						<li><a href="#tab_2" data-toggle="tab">Update Photo</a></li>
						<li><a href="#tab_3" data-toggle="tab">Update Password</a></li>
					</ul>
					<div class="tab-content">
          				<div class="tab-pane active" id="tab_1">
							
							<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">First Name <span>*</span></label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="fname" value="<?php echo $fname; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Last Name <span>*</span></label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="lname" value="<?php echo $lname; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Username <span>*</span></label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="username" value="<?php echo $username; ?>" disabled>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Email Address <span>*</span></label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="" maxlength="255" autocomplete="off" value="<?php echo $email; ?>" disabled>
										</div>
									</div>
									
									
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Phone </label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="phone" maxlength="255" autocomplete="off" value="<?php echo $phone; ?>">
										</div>
									</div>
							        <div class="form-group">
							            <label for="" class="col-sm-2 control-label">Status *</label>
							            <div class="col-sm-4">
							                <select name="status" class="form-control select2">
                                                <option value="Active" <?php if($status=='Active') {echo 'selected';} ?>>Active</option>
                                                <option value="Inactive" <?php if($status=='Inactive') {echo 'selected';} ?>>Inactive</option>
                                            </select>
							            </div>
							        </div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-4">
											<button type="submit" class="btn btn-success pull-left" name="form1">Update Information</button>
										</div>
									</div>
								</div>
							</div>
							</form>


          				</div>
          				<div class="tab-pane" id="tab_2">
							
							<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">Existing Photo</label>
							            <div class="col-sm-4" style="padding-top:6px;">
											<img src="uploads/<?php echo $photo; ?>" alt="User Photo" style="width:150px;">
							            </div>
							        </div>
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">New Photo</label>
							            <div class="col-sm-4" style="padding-top:6px;">
							                <input type="file" name="photo">
							            </div>
							        </div>
							        <div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-4">
											<button type="submit" class="btn btn-success pull-left" name="form2">Update Photo</button>
										</div>
									</div>
								</div>
							</div>
							</form>


          				</div>
          				<div class="tab-pane" id="tab_3">

							<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Password </label>
										<div class="col-sm-4">
											<input type="password" class="form-control" name="password">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Retype Password </label>
										<div class="col-sm-4">
											<input type="password" class="form-control" name="re_password">
										</div>
									</div>
							        <div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-4">
											<button type="submit" class="btn btn-success pull-left" name="form3">Update Password</button>
										</div>
									</div>
								</div>
							</div>
							</form>

          				</div>
          			</div>
				</div>
			
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>