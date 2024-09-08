<?php require_once('header.php'); ?>

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

	if($_SESSION['user']['id'] == 1) {
		if(empty($_POST['username'])) {
			$valid = 0;
			$error_message .= 'Username can not be empty<br>';
		} else {

            // current username that is in the database
            $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
            $statement->execute(array($_SESSION['user']['id']));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row) {
                $current_username = $row['username'];
            }

            $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE username=? and username!=?");
            $statement->execute(array($_POST['username'],$current_username));
            $total = $statement->rowCount();
            if($total) {
                $valid = 0;
                $error_message .= 'Username already exists<br>';
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
				// current email address that is in the database
				$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
				$statement->execute(array($_SESSION['user']['id']));
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				foreach($result as $row) {
					$current_email = $row['email'];
				}

				$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=? and email!=?");
				$statement->execute(array($_POST['email'],$current_email));
				$total = $statement->rowCount();
				if($total) {
					$valid = 0;
					$error_message .= 'Email address already exists<br>';
				}
			}
		}
    }

    if($valid == 1) {
        
        $_SESSION['user']['fname'] = $_POST['fname'];
        $_SESSION['user']['lname'] = $_POST['lname'];
        $_SESSION['user']['phone'] = $_POST['phone'];
	    if($_SESSION['user']['id'] == 1) {
		    $_SESSION['user']['username'] = $_POST['username'];
		    $_SESSION['user']['email'] = $_POST['email'];
        }

        // updating the database
	    if($_SESSION['user']['id'] == 1) {
		    $statement = $pdo->prepare("UPDATE tbl_user SET fname=?, lname=?, phone=?, username=?, email=? WHERE id=?");
		    $statement->execute(array($_POST['fname'],$_POST['lname'],$_POST['phone'],$_POST['username'],$_POST['email'],$_SESSION['user']['id']));
        } else {
		    $statement = $pdo->prepare("UPDATE tbl_user SET fname=?, lname=?, phone=? WHERE id=?");
		    $statement->execute(array($_POST['fname'],$_POST['lname'],$_POST['phone'],$_SESSION['user']['id']));
        }

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
        if($_SESSION['user']['photo']!='') {
            unlink('uploads/'.$_SESSION['user']['photo']);    
        }

        // updating the data
        $final_name = 'user-'.$_SESSION['user']['id'].'.'.$ext;
        move_uploaded_file( $path_tmp, 'uploads/'.$final_name );
        $_SESSION['user']['photo'] = $final_name;

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_user SET photo=? WHERE id=?");
        $statement->execute(array($final_name,$_SESSION['user']['id']));

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

        $_SESSION['user']['password'] = md5($_POST['password']);

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_user SET password=? WHERE id=?");
        $statement->execute(array(md5($_POST['password']),$_SESSION['user']['id']));

        $success_message = 'User Password is updated successfully.';
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Profile</h1>
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
											<input type="text" class="form-control" name="fname" maxlength="255" autocomplete="off" value="<?php echo $_SESSION['user']['fname']; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Last Name <span>*</span></label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="lname" maxlength="255" autocomplete="off" value="<?php echo $_SESSION['user']['lname']; ?>">
										</div>
									</div>
									
									
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Username <span>*</span></label>
										<?php
										if($_SESSION['user']['role'] != 'Admin') {
											?>
												<div class="col-sm-4">
													<input type="text" class="form-control" name="" maxlength="255" autocomplete="off" value="<?php echo $_SESSION['user']['username']; ?>" disabled>
												</div>
											<?php
										} else {
											?>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="username" maxlength="255" autocomplete="off" value="<?php echo $_SESSION['user']['username']; ?>">
											</div>
											<?php
										}
										?>										
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Email Address <span>*</span></label>
										<?php
										if($_SESSION['user']['role'] != 'Admin') {
											?>
												<div class="col-sm-4">
													<input type="text" class="form-control" name="" maxlength="255" autocomplete="off" value="<?php echo $_SESSION['user']['email']; ?>" disabled>
												</div>
											<?php
										} else {
											?>
											<div class="col-sm-4">
												<input type="text" class="form-control" name="email" maxlength="255" autocomplete="off" value="<?php echo $_SESSION['user']['email']; ?>">
											</div>
											<?php
										}
										?>										
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Phone </label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="phone" maxlength="255" autocomplete="off" value="<?php echo $_SESSION['user']['phone']; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Role <span>*</span></label>
										<div class="col-sm-4" style="padding-top:7px;">
											<input type="text" class="form-control" name="" maxlength="255" autocomplete="off" value="<?php echo $_SESSION['user']['role']; ?>" disabled>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
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
							            <div class="col-sm-6" style="padding-top:6px;">
							            	<img src="uploads/<?php echo $_SESSION['user']['photo']; ?>" alt="User Photo" style="width:150px;">
							            </div>
							        </div>
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">New Photo</label>
							            <div class="col-sm-6" style="padding-top:6px;">
							                <input type="file" name="photo">
							            </div>
							        </div>
							        <div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
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
										<div class="col-sm-6">
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