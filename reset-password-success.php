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
    	<h4 class="login-box-msg">Reset Password Success</h4>
    
	    <?php 
	    if( (isset($error_message)) && ($error_message!='') ):
	        echo '<div class="error">'.$error_message.'</div>';
	    endif;

	    if( (isset($success_message)) && ($success_message!='') ):
	        echo '<div class="success">'.$success_message.'</div>';
	    endif;
	    ?>

		<p class="login-box-msg" style="text-align: left;">
    	    Password is reset successfully. You can now login. <br><br>
			
			<a href="login.php" style="text-decoration: underline;color: green;">back to login page
    	</p>
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