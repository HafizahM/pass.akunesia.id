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

if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}
?>

<?php
$q = $pdo->prepare("SELECT * FROM tbl_setting WHERE id=1");
$q->execute();
$result = $q->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$logo = $row['logo'];
	$favicon = $row['favicon'];
	$title_website = $row['title_website'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $title_website; ?></title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/summernote.css">
	<link rel="stylesheet" href="css/main.css">

	<link rel="icon" href="uploads/<?php echo $favicon; ?>" type="image/png">


	<style>
		.skin-blue .wrapper,
		.skin-blue .main-header .logo,
		.skin-blue .main-header .navbar,
		.skin-blue .main-sidebar,
		.content-header .content-header-right a,
		.content .form-horizontal .btn-success {
			background-color: #117eaf!important;
		}

		.content-header .content-header-right a,
		.content .form-horizontal .btn-success {
			border-color: #117eaf!important;
		}
		
		.content-header>h1,
		.content-header .content-header-left h1,
		h3 {
			color: #117eaf!important;
		}

		.skin-blue .sidebar a {
			color: #fff!important;
		}

		.skin-blue .sidebar-menu>li>.treeview-menu {
			margin: 0!important;
		}
		.skin-blue .sidebar-menu>li>a {
			border-left: 0!important;
		}
	</style>



</head>

<body class="hold-transition fixed skin-blue sidebar-mini">

	<div class="wrapper">

		<header class="main-header">

			<a href="index.php" class="logo">
				<span class="logo-lg">
					<img src="uploads/<?php echo $logo; ?>" alt="" style="max-width:100%;max-height:50px;padding:5px 0;">
				</span>
			</a>

			<nav class="navbar navbar-static-top">
				
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<span style="float:left;line-height:50px;color:#fff;padding-left:15px;font-size:18px;">Easy Password Manager</span>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<?php if($_SESSION['user']['photo'] == ''): ?>
									<img src="img/no-photo.jpg" class="user-image" alt="user photo">
								<?php else: ?>
									<img src="uploads/<?php echo $_SESSION['user']['photo']; ?>" class="user-image" alt="user photo">
								<?php endif; ?>
								
								<span class="hidden-xs"><?php echo $_SESSION['user']['username']; ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="profile-edit.php" class="btn btn-default btn-flat">Edit Profile</a>
									</div>
									<div>
										<a href="logout.php" class="btn btn-default btn-flat">Log out</a>
									</div>
								</li>
							</ul>
						</li>
						
					</ul>
				</div>

			</nav>
		</header>

  		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); ?>

  		<aside class="main-sidebar">
    		<section class="sidebar">
      
      			<ul class="sidebar-menu">

			        <li class="treeview <?php if($cur_page == 'index.php') {echo 'active';} ?>">
			          <a href="index.php">
			            <i class="fa fa-hand-o-right"></i> <span>Dashboard</span>
			          </a>
			        </li>


			        <?php if($_SESSION['user']['id'] != 1): ?>
					<li class="treeview <?php if($cur_page == 'item-user.php') {echo 'active';} ?>">
			          <a href="item-user.php">
			            <i class="fa fa-hand-o-right"></i> <span>My Items</span>
			          </a>
			        </li>
					<?php endif; ?>

					
					<?php if($_SESSION['user']['id'] == 1): ?>

					<li class="treeview <?php if( ($cur_page == 'setting-general.php')||($cur_page == 'setting-logo.php')||($cur_page == 'setting-favicon.php')||($cur_page == 'setting-login-bg.php')||($cur_page == 'setting-email.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>Setting</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="setting-general.php"><i class="fa fa-circle-o"></i> General</a></li>
							<li><a href="setting-logo.php"><i class="fa fa-circle-o"></i> Logo</a></li>
							<li><a href="setting-favicon.php"><i class="fa fa-circle-o"></i> Favicon</a></li>
							<li><a href="setting-login-bg.php"><i class="fa fa-circle-o"></i> Login Background</a></li>
							<li><a href="setting-email.php"><i class="fa fa-circle-o"></i> Email</a></li>
						</ul>
					</li>

					<li class="treeview <?php if( ($cur_page == 'category-add.php')||($cur_page == 'category.php')||($cur_page == 'category-edit.php') ) {echo 'active';} ?>">
			          <a href="category.php">
			            <i class="fa fa-hand-o-right"></i> <span>Category</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'user-add.php')||($cur_page == 'user.php')||($cur_page == 'user-edit.php') ) {echo 'active';} ?>">
			          <a href="user.php">
			            <i class="fa fa-hand-o-right"></i> <span>User</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'group-add.php')||($cur_page == 'group.php')||($cur_page == 'group-edit.php') ) {echo 'active';} ?>">
			          <a href="group.php">
			            <i class="fa fa-hand-o-right"></i> <span>Group</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'item-add.php')||($cur_page == 'item.php')||($cur_page == 'item-edit.php') ) {echo 'active';} ?>">
			          <a href="item.php">
			            <i class="fa fa-hand-o-right"></i> <span>Item</span>
			          </a>
			        </li>
			        
			        <li class="treeview <?php if( ($cur_page == 'send-mail-user.php')||($cur_page == 'send-mail-group.php')||($cur_page == 'all-mail-user.php')||($cur_page == 'all-mail-group.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>Mail</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="send-mail-user.php"><i class="fa fa-circle-o"></i> Send Mail to User</a></li>
							<li><a href="send-mail-group.php"><i class="fa fa-circle-o"></i> Send Mail to Group</a></li>
							<li><a href="all-mail-user.php"><i class="fa fa-circle-o"></i> All Mails to User</a></li>
							<li><a href="all-mail-group.php"><i class="fa fa-circle-o"></i> All Mails to Group</a></li>
						</ul>
					</li>

					<li class="treeview <?php if( ($cur_page == 'export-all-item-csv.php')||($cur_page == 'export-all-user-csv.php')||($cur_page == 'export-all-group-csv.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>Export (as CSV)</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="export-all-item-csv.php"><i class="fa fa-circle-o"></i> All Items</a></li>
							<li><a href="export-all-user-csv.php"><i class="fa fa-circle-o"></i> All Users</a></li>
							<li><a href="export-all-group-csv.php"><i class="fa fa-circle-o"></i> All Groups</a></li>
							<li><a href="export-all-mail-user-csv.php"><i class="fa fa-circle-o"></i> All Mails to Users</a></li>
							<li><a href="export-all-mail-group-csv.php"><i class="fa fa-circle-o"></i> All Mails to Groups</a></li>
						</ul>
					</li>			    	
			    	<?php endif; ?>
        
      			</ul>
    		</section>
  		</aside>

  		<div class="content-wrapper">