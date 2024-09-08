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
if(isset($_POST['form1'])) {

    $username_or_email = strip_tags($_POST['username_or_email']);
    $password = strip_tags($_POST['password']);
        
    if(empty($username_or_email) || empty($password)) {
        $error_message = 'Enter correct username (or email address) and password<br>';
    } else {
        $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE username=? OR email=?");
        $statement->execute(array($username_or_email,$username_or_email));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
        if($total==0) {
            $error_message .= 'Enter correct username (or email address) and password<br>';
        } else {
            foreach($result as $row) {
                $row_password = $row['password'];
                $status = $row['status'];
            }
            
            if($status != 'Active') {
                $error_message .= 'Your account is inactive. Please contact the administrator to know details.<br>';
            } else {
                if($row_password != md5($password) ) {
                    $error_message .= 'Enter correct username (or email address) and password<br>';
                } else {       
                    $_SESSION['user'] = $row;
                    header("location: ".BASE_URL);
                }    
            }
            
        }
    }        
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>

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

	<link rel="icon" href="uploads/<?php echo $favicon; ?>" type="image/png">

	<style>
		
		.login-page {
			background-repeat: no-repeat;
			background-position: center center;
			-webkit-background-size: cover;
			background-size: cover;
			background-image: url(uploads/<?php echo $login_bg; ?>)!important;
		}
	</style>

</head>

<body class="hold-transition login-page sidebar-mini">

<div class="login-box">
	<div class="login-logo" style="color: white;font-weight: 500;font-size: 22px;">
		<!-- <b><img src="uploads/<?php echo $logo; ?>" alt="" style="max-width: 100%;"></b> -->
		<?php echo $title_login; ?>
	</div>
  	<div class="login-box-body">
    	<h4 class="login-box-msg">Please login to continue</h4>
    
	    <?php 
	    if( (isset($error_message)) && ($error_message!='') ):
	        echo '<div class="error">'.$error_message.'</div>';
	    endif;
	    ?>

		<form action="" method="post">
			<div class="form-group has-feedback">
				<input class="form-control" placeholder="Username or Email Address" name="username_or_email" type="text" autocomplete="off" autofocus>
			</div>
			<div class="form-group has-feedback">
				<input class="form-control" placeholder="Password" name="password" type="password" autocomplete="off" value="">
			</div>
			<div class="row">
				<div class="col-xs-8" style="padding-top:7px;"><a href="forget-password.php" style="color:red;">Forget Password?</a></div>
				<div class="col-xs-4">
					<input type="submit" class="btn btn-primary btn-block btn-flat login-button" name="form1" value="Log In">
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