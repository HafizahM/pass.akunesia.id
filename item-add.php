<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
if(isset($_POST['form1'])) {
    
    $valid = 1;

    $name = strip_tags($_POST['name']);
    $url = strip_tags($_POST['url']);
    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);
    $extra_info = strip_tags($_POST['extra_info']);

    $e_name = encr($name,PRIVATE_KEY);
    $e_url = encr($url,PRIVATE_KEY);
    $e_username = encr($username,PRIVATE_KEY);
    $e_password = encr($password,PRIVATE_KEY);
    $e_extra_info = encr($extra_info,PRIVATE_KEY);


    if(empty($name)) {
        $valid = 0;
        $error_message .= "Item Name can not be empty<br>";
    }
    if($valid == 1) {

        $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_item'");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row) {$ai_id=$row[10];}

        // saving into the database
        $statement = $pdo->prepare("INSERT INTO tbl_item (name,url,username,password,extra_info,category_id) VALUES (?,?,?,?,?,?)");
        $statement->execute(array($e_name,$e_url,$e_username,$e_password,$e_extra_info,$_POST['category_id']));

        if(isset($_POST['user_ids'])) {
            foreach($_POST['user_ids'] as $val) {
                $statement = $pdo->prepare("INSERT INTO tbl_item_user (item_id,user_id) VALUES (?,?)");
                $statement->execute(array($ai_id,$val));
            }
        }

        if(isset($_POST['group_ids'])) {
            foreach($_POST['group_ids'] as $val) {
                $statement = $pdo->prepare("INSERT INTO tbl_item_group (item_id,group_id) VALUES (?,?)");
                $statement->execute(array($ai_id,$val));
            }
        }

        $success_message = 'Item is added successfully.';

        unset($_POST['name']);
        unset($_POST['url']);
        unset($_POST['username']);
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Item</h1>
	</div>
	<div class="content-header-right">
		<a href="item.php" class="btn btn-primary btn-sm">View All</a>
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

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_general" data-toggle="tab">General</a></li>
                        <li><a href="#tab_user" data-toggle="tab">User Selection</a></li>
                        <li><a href="#tab_group" data-toggle="tab">Group Selection</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_general">
                            
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Name <span>*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="name" maxlength="255" autocomplete="off" value="<?php if(isset($_POST['name'])) {echo $_POST['name'];} ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">URL</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="url" maxlength="255" autocomplete="off" value="<?php if(isset($_POST['url'])) {echo $_POST['url'];} ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Username</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="username" maxlength="255" autocomplete="off" value="<?php if(isset($_POST['username'])) {echo $_POST['username'];} ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Password</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="password" maxlength="255" autocomplete="off" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Extra Information</label>
                                        <div class="col-sm-4">
                                            <textarea name="extra_info" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Select Category</label>
                                        <div class="col-sm-4">
                                            <select name="category_id" class="form-control select2">
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_category ORDER BY category_name ASC");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                    ?>
                                                    <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="tab-pane" id="tab_user">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Select Users</label>
                                        <div class="col-sm-4">
                                            <select name="user_ids[]" class="form-control select2" multiple style="width:100%;">
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id!=1 ORDER BY username ASC");
                                                $statement->execute();
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
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_group">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Select Groups</label>
                                        <div class="col-sm-4">
                                            <select name="group_ids[]" class="form-control select2" multiple style="width:100%;">
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM tbl_group ORDER BY group_name ASC");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                    ?>
                                                    <option value="<?php echo $row['group_id']; ?>"><?php echo $row['group_name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
            </form>
			
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>