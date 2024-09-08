<?php
ob_start();
session_start();
include("inc/config.php");
include("inc/functions.php");

include("inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();

$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';
$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
?>

<?php
if( !isset($_GET['email']) || !isset($_GET['token']) )
{
	header('location: '.BASE_URL.'login.php');
	exit;
}

$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=? AND token=?");
$statement->execute(array($_GET['email'],$_GET['token']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$tot = $statement->rowCount();
if($tot == 0)
{
	header('location: '.BASE_URL.'login.php');
	exit;
}

if(isset($_POST['form1'])) {

	$valid = 1;
	
	if( empty($_POST['new_password']) || empty($_POST['re_password']) )
	{
		$valid = 0;
        $error_message .= 'Please enter new and retype passwords.<br>';
	}
	else
	{
		if($_POST['new_password'] != $_POST['re_password'])
        {
            $valid = 0;
            $error_message .= 'Passwords do not match.<br>';
        }
	}	

	if($valid == 1) {
		$statement = $pdo->prepare("UPDATE tbl_user SET password=?, token=? WHERE email=?");
		$statement->execute(array(md5($_POST['new_password']),'',$_GET['email']));
		
		header('location: '.BASE_URL.'reset-password-success.php');
	}
}
?>
<?php 
	$statement = $pdo->prepare("SELECT * FROM tbl_setting WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$logo = $row['logo'];
		$login_bg = $row['login_bg'];
		$favicon = $row['favicon'];
		$title_login = $row['title_login'];
	}
	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Reset Password</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">

	<link rel="stylesheet" href="css/main.css">

	<link rel="icon" href="uploads/<?php echo $favicon; ?>" type="image/png">
	
	<style>
		.login-page {
			background-image: url(uploads/<?php echo $login_bg; ?>)!important;
		}
	</style>

</head>

<body class="hold-transition login-page sidebar-mini">

<div class="login-box">
	<div class="login-logo" style="color: white;font-weight: 500;font-size: 22px;">
		<?php echo $title_login; ?>
	</div>
  	<div class="login-box-body">
    	<h4 class="login-box-msg">Reset Password</h4>
    
	    <?php 
	    if( (isset($error_message)) && ($error_message!='') ):
	        echo '<div class="error">'.$error_message.'</div>';
	    endif;

	    if( (isset($success_message)) && ($success_message!='') ):
	        echo '<div class="success">'.$success_message.'</div>';
	    endif;
	    ?>

		<form action="" method="post">
			<div class="form-group has-feedback">
				<input class="form-control" placeholder="New Password" name="new_password" type="password" autocomplete="off" autofocus>
			</div>
			<div class="form-group has-feedback">
				<input class="form-control" placeholder="Retype Password" name="re_password" type="password" autocomplete="off" autofocus>
			</div>
			<div class="row">
				<div class="col-xs-8" style="padding-top:7px;"><a href="login.php" style="color:red;">back to login page</a></div>
				<div class="col-xs-4">
					<input type="submit" class="btn btn-primary btn-block btn-flat login-button" name="form1" value="Submit">
				</div>
			</div>
		</form>
	</div>
</div>


<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/select2.full.min.js"></script>
<script src="js/jquery.inputmask.js"></script>
<script src="js/jquery.inputmask.date.extensions.js"></script>
<script src="js/jquery.inputmask.extensions.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/icheck.min.js"></script>
<script src="js/fastclick.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>

</body>
</html>