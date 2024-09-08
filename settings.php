<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	$path = $_FILES['photo_logo']['name'];
    $path_tmp = $_FILES['photo_logo']['tmp_name'];

    if($path == '') {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='JPG' && $ext!='PNG' && $ext!='JPEG' && $ext!='GIF' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {

    	// removing the existing photo
    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$logo = $row['logo'];
    		unlink('../assets/uploads/'.$logo);
    	}

    	// updating the data
    	$final_name = 'logo'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
    	
        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_settings SET logo=? WHERE id=1");
		$statement->execute(array($final_name));

        $success_message = 'Logo is updated successfully.';
    	
    }
}

if(isset($_POST['form1_1'])) {
	$valid = 1;

	$path = $_FILES['photo_logo_admin']['name'];
    $path_tmp = $_FILES['photo_logo_admin']['tmp_name'];

    if($path == '') {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='JPG' && $ext!='PNG' && $ext!='JPEG' && $ext!='GIF' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {

    	// removing the existing photo
    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$logo_admin = $row['logo_admin'];
    		unlink('../assets/uploads/'.$logo_admin);
    	}

    	// updating the data
    	$final_name = 'logo_admin'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
    	
        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_settings SET logo_admin=? WHERE id=1");
		$statement->execute(array($final_name));

        $success_message = 'Admin Logo is updated successfully.';
    	
    }
}

if(isset($_POST['form2'])) {
	$valid = 1;

	$path = $_FILES['photo_favicon']['name'];
    $path_tmp = $_FILES['photo_favicon']['tmp_name'];

    if($path == '') {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='JPG' && $ext!='PNG' && $ext!='JPEG' && $ext!='GIF' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {

    	// removing the existing photo
    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$favicon = $row['favicon'];
    		unlink('../assets/uploads/'.$favicon);
    	}

    	// updating the data
    	$final_name = 'favicon'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
    	
        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_settings SET favicon=? WHERE id=1");
		$statement->execute(array($final_name));

        $success_message = 'Favicon is updated successfully.';
    	
    }
}




if(isset($_POST['form8'])) {
	$valid = 1;

	$path = $_FILES['login_bg']['name'];
    $path_tmp = $_FILES['login_bg']['tmp_name'];

    if($path == '') {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='JPG' && $ext!='PNG' && $ext!='JPEG' && $ext!='GIF' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {

    	// removing the existing photo
    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$login_bg = $row['login_bg'];
    		unlink('../assets/uploads/'.$login_bg);
    	}

    	// updating the data
    	$final_name = 'login_bg'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
    	
        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_settings SET login_bg=? WHERE id=1");
		$statement->execute(array($final_name));

        $success_message = 'Login Background is updated successfully.';
    	
    }
}


if(isset($_POST['form6_1'])) {
	$valid = 1;

	$path = $_FILES['home_banner']['name'];
    $path_tmp = $_FILES['home_banner']['tmp_name'];

    if($path == '') {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='JPG' && $ext!='PNG' && $ext!='JPEG' && $ext!='GIF' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {

    	// removing the existing photo
    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$home_banner = $row['home_banner'];
    		unlink('../assets/uploads/'.$home_banner);
    	}

    	// updating the data
    	$final_name = 'home_banner'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
    	
        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_settings SET home_banner=? WHERE id=1");
		$statement->execute(array($final_name));

        $success_message = 'Home Page Banner is updated successfully.';
    	
    }
}


if(isset($_POST['form6_2'])) {
	$valid = 1;

	$path = $_FILES['subscriber']['name'];
    $path_tmp = $_FILES['subscriber']['tmp_name'];

    if($path == '') {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='JPG' && $ext!='PNG' && $ext!='JPEG' && $ext!='GIF' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {

    	// removing the existing photo
    	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    	foreach ($result as $row) {
    		$subscriber = $row['subscriber'];
    		unlink('../assets/uploads/'.$subscriber);
    	}

    	// updating the data
    	$final_name = 'subscriber'.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
    	
        // updating the database
		$statement = $pdo->prepare("UPDATE tbl_settings SET subscriber=? WHERE id=1");
		$statement->execute(array($final_name));

        $success_message = 'Subscriber Banner is updated successfully.';
    	
    }
}

if(isset($_POST['form3'])) {
	
	// updating the database
	$statement = $pdo->prepare("UPDATE tbl_settings SET footer_copyright=?, contact_address=?, contact_email=?, contact_phone=?, contact_fax=?, contact_map_iframe=? WHERE id=1");
	$statement->execute(array($_POST['footer_copyright'],$_POST['contact_address'],$_POST['contact_email'],$_POST['contact_phone'],$_POST['contact_fax'],$_POST['contact_map_iframe']));

	$success_message = 'General content settings is updated successfully.';
    
}

if(isset($_POST['form4'])) {
	// updating the database
	$statement = $pdo->prepare("UPDATE tbl_settings SET receive_email=? WHERE id=1");
	$statement->execute(array($_POST['receive_email']));

	$success_message = 'Contact form settings information is updated successfully.';
}


if(isset($_POST['form5'])) {
	// updating the database
	$statement = $pdo->prepare("UPDATE tbl_settings SET total_featured_channels=?, total_recent_channels=?, total_popular_channels=? WHERE id=1");
	$statement->execute(array($_POST['total_featured_channels'],$_POST['total_recent_channels'],$_POST['total_popular_channels']));

	$success_message = 'Footer settings is updated successfully.';
}

if(isset($_POST['form6'])) {
	// updating the database
	$statement = $pdo->prepare("UPDATE tbl_settings SET meta_title_home=?, meta_keyword_home=?, meta_description_home=? WHERE id=1");
	$statement->execute(array($_POST['meta_title_home'],$_POST['meta_keyword_home'],$_POST['meta_description_home']));

	$success_message = 'Home Meta settings is updated successfully.';
}

if(isset($_POST['form7'])) {
	// updating the database
	$statement = $pdo->prepare("UPDATE tbl_settings SET color_front_end=?, color_back_end=? WHERE id=1");
	$statement->execute(array($_POST['color_front_end'],$_POST['color_back_end']));

	$success_message = 'Color settings is updated successfully.';
}

if(isset($_POST['form6_3'])) {

    $statement = $pdo->prepare("UPDATE tbl_home_category SET category_order=?");
    $statement->execute(array(''));

    foreach ($_POST['category_id'] as $key => $value) {
        $arr1[] = $value;
    }
    foreach ($_POST['category_order'] as $key => $value) {
        $arr2[] = $value;
    }

    for($i=0;$i<count($arr1);$i++) {
        if($arr2[$i] != '') {
            $statement = $pdo->prepare("UPDATE tbl_home_category SET category_order=? WHERE category_id=?");
            $statement->execute(array($arr2[$i],$arr1[$i]));
        }
    }

    $success_message = 'Home Category Settings is updated successfully.';

}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Settings</h1>
	</div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$logo                            = $row['logo'];
	$logo_admin                      = $row['logo_admin'];
	$favicon                         = $row['favicon'];
	$home_banner                     = $row['home_banner'];
	$subscriber                      = $row['subscriber'];
	$login_bg                        = $row['login_bg'];
	$footer_copyright                = $row['footer_copyright'];
	$contact_address                 = $row['contact_address'];
	$contact_email                   = $row['contact_email'];
	$contact_phone                   = $row['contact_phone'];
	$contact_fax                     = $row['contact_fax'];
	$contact_map_iframe              = $row['contact_map_iframe'];
	$receive_email                   = $row['receive_email'];
	$total_featured_channels         = $row['total_featured_channels'];
	$total_recent_channels           = $row['total_recent_channels'];
	$total_popular_channels          = $row['total_popular_channels'];
	$meta_title_home                 = $row['meta_title_home'];
	$meta_keyword_home               = $row['meta_keyword_home'];
	$meta_description_home           = $row['meta_description_home'];
	$color_front_end                 = $row['color_front_end'];
	$color_back_end                  = $row['color_back_end'];
}
?>


<section class="content" style="min-height:auto;margin-bottom: -30px;">
	<div class="row">
		<div class="col-md-12">
			<?php if($error_message): ?>
			<div class="callout callout-danger">
			<h4>Please correct the following errors:</h4>
			<p>
			<?php echo $error_message; ?>
			</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
			<h4>Success:</h4>
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
						<li class="active"><a href="#tab_1" data-toggle="tab">Logo</a></li>
						<li><a href="#tab_2" data-toggle="tab">Favicon</a></li>
						<li><a href="#tab_8" data-toggle="tab">Login Background</a></li>
						<li><a href="#tab_3" data-toggle="tab">General Content</a></li>
						<li><a href="#tab_4" data-toggle="tab">Email Settings</a></li>
						<li><a href="#tab_5" data-toggle="tab">Footer</a></li>
						<li><a href="#tab_6" data-toggle="tab">Home Page</a></li>
						<li><a href="#tab_7" data-toggle="tab">Color</a></li>
					</ul>
					<div class="tab-content">
          				<div class="tab-pane active" id="tab_1">
							
							<h3 style="font-size:18px;">Website Logo</h3>

          					<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          					<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">Existing Photo</label>
							            <div class="col-sm-6" style="padding-top:6px;background: #f2f2f2;">
							                <img src="../assets/uploads/<?php echo $logo; ?>" class="existing-photo" style="height:80px;">
							            </div>
							        </div>
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">New Photo</label>
							            <div class="col-sm-6" style="padding-top:6px;">
							                <input type="file" name="photo_logo">
							            </div>
							        </div>
							        <div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form1">Update Logo</button>
										</div>
									</div>
								</div>
							</div>
							</form>

							<h3 style="font-size:18px;">Admin Logo</h3>
							

							<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          					<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">Existing Photo</label>
							            <div class="col-sm-6" style="padding-top:6px;background: #f2f2f2;">
							                <img src="../assets/uploads/<?php echo $logo_admin; ?>" class="existing-photo" style="height:80px;">
							            </div>
							        </div>
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">New Photo</label>
							            <div class="col-sm-6" style="padding-top:6px;">
							                <input type="file" name="photo_logo_admin">
							            </div>
							        </div>
							        <div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form1_1">Update Logo</button>
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
							                <img src="../assets/uploads/<?php echo $favicon; ?>" class="existing-photo" style="height:40px;">
							            </div>
							        </div>
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">New Photo</label>
							            <div class="col-sm-6" style="padding-top:6px;">
							                <input type="file" name="photo_favicon">
							            </div>
							        </div>
							        <div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form2">Update Favicon</button>
										</div>
									</div>
								</div>
							</div>
							</form>


          				</div>



          				<div class="tab-pane" id="tab_8">

          					<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">Existing Photo</label>
							            <div class="col-sm-6" style="padding-top:6px;">
							                <img src="../assets/uploads/<?php echo $login_bg; ?>" class="existing-photo" style="width:500px;">
							            </div>
							        </div>
									<div class="form-group">
							            <label for="" class="col-sm-2 control-label">New Photo</label>
							            <div class="col-sm-6" style="padding-top:6px;">
							                <input type="file" name="login_bg">
							            </div>
							        </div>
							        <div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form8">Update Photo</button>
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
										<label for="" class="col-sm-2 control-label">Footer - Copyright </label>
										<div class="col-sm-9">
											<input class="form-control" type="text" name="footer_copyright" value="<?php echo $footer_copyright; ?>">
										</div>
									</div>								
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Contact Address </label>
										<div class="col-sm-6">
											<textarea class="form-control" name="contact_address" style="height:140px;"><?php echo $contact_address; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Contact Email </label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="contact_email" value="<?php echo $contact_email; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Contact Phone Number </label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="contact_phone" value="<?php echo $contact_phone; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Contact Fax Number </label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="contact_fax" value="<?php echo $contact_fax; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Contact Map iFrame </label>
										<div class="col-sm-9">
											<textarea class="form-control" name="contact_map_iframe" style="height:200px;"><?php echo $contact_map_iframe; ?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form3">Update Footer</button>
										</div>
									</div>
								</div>
							</div>
							</form>


          				</div>

          				<div class="tab-pane" id="tab_4">

          					<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-4 control-label">Email Address (Contact Form) <span>*</span></label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="receive_email" value="<?php echo $receive_email; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-4 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form4">Update</button>
										</div>
									</div>
								</div>
							</div>
							</form>


          				</div>

          				<div class="tab-pane" id="tab_5">

          					<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-3 control-label">How many featured channels? <span>*</span></label>
										<div class="col-sm-5">
											<input type="text" class="form-control" name="total_featured_channels" value="<?php echo $total_featured_channels; ?>">
											If you do not want to show recent channels, put value to 0
										</div>
									</div>	
									<div class="form-group">
										<label for="" class="col-sm-3 control-label">How many recent channels? <span>*</span></label>
										<div class="col-sm-5">
											<input type="text" class="form-control" name="total_recent_channels" value="<?php echo $total_recent_channels; ?>">
											If you do not want to show recent channels, put value to 0
										</div>
									</div>		
									<div class="form-group">
										<label for="" class="col-sm-3 control-label">How many popular channels? <span>*</span></label>
										<div class="col-sm-5">
											<input type="text" class="form-control" name="total_popular_channels" value="<?php echo $total_popular_channels; ?>">
											If you do not want to show popular channels, put value to 0
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-3 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form5">Update</button>
										</div>
									</div>
								</div>
							</div>
							</form>


          				</div>


          				<div class="tab-pane" id="tab_6">


          					<h3 style="font-size: 18px;">Main Banner Photo</h3>

          					<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Previous Photo </label>
										<div class="col-sm-9">
											<img src="../assets/uploads/<?php echo $home_banner; ?>" alt="" style="width:500px;">
										</div>
									</div>		
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Change Photo </label>
										<div class="col-sm-9">
											<input type="file" name="home_banner">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form6_1">Update</button>
										</div>
									</div>
								</div>
							</div>
							</form>



							<h3 style="font-size: 18px;">Subscriber Background Photo</h3>

          					<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Previous Photo </label>
										<div class="col-sm-9">
											<img src="../assets/uploads/<?php echo $subscriber; ?>" alt="" style="width:500px;">
										</div>
									</div>		
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Change Photo </label>
										<div class="col-sm-9">
											<input type="file" name="subscriber">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form6_2">Update</button>
										</div>
									</div>
								</div>
							</div>
							</form>


							
							<h3 style="font-size: 18px;">Meta Information</h3>

          					<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Meta Title </label>
										<div class="col-sm-9">
											<input type="text" name="meta_title_home" class="form-control" value="<?php echo $meta_title_home ?>">
										</div>
									</div>		
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Meta Keyword </label>
										<div class="col-sm-9">
											<textarea class="form-control" name="meta_keyword_home" style="height:100px;"><?php echo $meta_keyword_home ?></textarea>
										</div>
									</div>	
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Meta Description </label>
										<div class="col-sm-9">
											<textarea class="form-control" name="meta_description_home" style="height:200px;"><?php echo $meta_description_home ?></textarea>
										</div>
									</div>	
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form6">Update</button>
										</div>
									</div>
								</div>
							</div>
							</form>




                            <h3 style="font-size: 18px;">Home Page Channel Categories</h3>

                            <form class="form-horizontal" action="" method="post">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            
                                            <p style="padding-bottom: 20px;">If you do not want to show a channel category in your home page, just leave the order field blank.</p>

                                            <table class="table table-bordered table-striped table-responsive" style="width:auto;">
                                                <thead>
                                                    <tr>
                                                        <th>Category Name</th>
                                                        <th>Order</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $statement = $pdo->prepare("SELECT 
                                                                                
                                                                                t1.id,
                                                                                t1.category_id,
                                                                                t1.category_order,

                                                                                t2.category_id,
                                                                                t2.category_name

                                                                                FROM tbl_home_category t1
                                                                                JOIN tbl_category t2
                                                                                ON t1.category_id = t2.category_id

                                                                                ORDER by t2.category_name ASC
                                                                               ");
                                                    $statement->execute();
                                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
                                                    foreach ($result as $row) {
                                                        ?>
                                                        <input type="hidden" name="category_id[]" value="<?php echo $row['category_id']; ?>">
                                                        <tr>
                                                            <td style="padding-top:14px;"><?php echo $row['category_name']; ?></td>
                                                            <td><input type="text" class="form-control" name="category_order[]" value="<?php echo $row['category_order']; ?>" style="width:100px;"></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form6_3">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>






          				</div>


          				<div class="tab-pane" id="tab_7">

          					<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Front End Color </label>
										<div class="col-sm-2">
											<input type="text" name="color_front_end" class="form-control jscolor" value="<?php echo $color_front_end; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Back End Color </label>
										<div class="col-sm-2">
											<input type="text" name="color_back_end" class="form-control jscolor" value="<?php echo $color_back_end; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form7">Update</button>
										</div>
									</div>
								</div>
							</div>
							</form>


          				</div>


          			</div>
				</div>

				

			</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>