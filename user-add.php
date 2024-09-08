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

    if(empty($_POST['username'])) {
        $valid = 0;
        $error_message .= "Username can not be empty<br>";
    } else {
        // Duplicate Category checking
        $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE username=?");
        $statement->execute(array($_POST['username']));
        $total = $statement->rowCount();
        if($total)
        {
            $valid = 0;
            $error_message .= "Username already exists<br>";
        }
    }

    if(empty($_POST['email'])) {
        $valid = 0;
        $error_message .= 'Email address can not be empty<br>';
    } else {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= 'Email address must be valid<br>';
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=?");
            $statement->execute(array($_POST['email']));
            $total = $statement->rowCount();                            
            if($total) {
                $valid = 0;
                $error_message .= 'Email address already exists<br>';
            }
        }
    }

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
       
        if($path=='') {
            // saving into the database
            $statement = $pdo->prepare("INSERT INTO tbl_user (fname,lname,username,email,phone,password,photo,role,token,status) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $statement->execute(array($_POST['fname'],$_POST['lname'],$_POST['username'],$_POST['email'],$_POST['phone'],md5($_POST['password']),'','User','',$_POST['status']));
        } else {
            // getting auto increment id for photo renaming
            $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_user'");
            $statement->execute();
            $result = $statement->fetchAll();
            foreach($result as $row) {
                $ai_id=$row[10];
            }

            // uploading the photo into the main location and giving it a final name
            $final_name = 'user-'.$ai_id.'.'.$ext;
            move_uploaded_file( $path_tmp, 'uploads/'.$final_name );

            // saving into the database
            $statement = $pdo->prepare("INSERT INTO tbl_user (fname,lname,username,email,phone,password,photo,role,token,status) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $statement->execute(array($_POST['fname'],$_POST['lname'],$_POST['username'],$_POST['email'],$_POST['phone'],md5($_POST['password']),$final_name,'User','',$_POST['status']));
        }

        $success_message = 'User is added successfully.';

        unset($_POST['fname']);
        unset($_POST['lname']);
        unset($_POST['username']);
        unset($_POST['email']);
        unset($_POST['phone']);
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add User</h1>
	</div>
	<div class="content-header-right">
		<a href="user.php" class="btn btn-primary btn-sm">View All</a>
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

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">First Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="fname" maxlength="255" autocomplete="off" value="<?php if(isset($_POST['fname'])) {echo $_POST['fname'];} ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Last Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="lname" maxlength="255" autocomplete="off" value="<?php if(isset($_POST['lname'])) {echo $_POST['lname'];} ?>">
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Username <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="username" maxlength="255" autocomplete="off" value="<?php if(isset($_POST['username'])) {echo $_POST['username'];} ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Email Address <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="email" maxlength="255" autocomplete="off" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];} ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Phone Number </label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="phone" maxlength="255" autocomplete="off" value="<?php if(isset($_POST['phone'])) {echo $_POST['phone'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Password <span>*</span></label>
							<div class="col-sm-4">
								<input type="password" class="form-control" name="password" maxlength="255" autocomplete="off" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Retype Password <span>*</span></label>
							<div class="col-sm-4">
								<input type="password" class="form-control" name="re_password" maxlength="255" autocomplete="off" value="">
							</div>
						</div>
				        <div class="form-group">
				            <label for="" class="col-sm-2 control-label">Status *</label>
				            <div class="col-sm-4">
				                <select name="status" class="form-control select2">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
				            </div>
				        </div>
				        <div class="form-group">
				            <label for="" class="col-sm-2 control-label">Photo *</label>
				            <div class="col-sm-6" style="padding-top:6px;">
				              	<input type="file" name="photo">
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