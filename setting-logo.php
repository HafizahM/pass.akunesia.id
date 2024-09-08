<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
if(isset($_POST['form1'])) {
    $valid = 1;

    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

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
        $statement = $pdo->prepare("SELECT * FROM tbl_setting WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $logo = $row['logo'];
            unlink('uploads/'.$logo);
        }

        // updating the data
        $final_name = 'logo'.'.'.$ext;
        move_uploaded_file( $path_tmp, 'uploads/'.$final_name );
        
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_setting SET logo=? WHERE id=1");
        $statement->execute(array($final_name));

        $success_message = 'Logo is updated successfully.';
        
    }
}
?>

<?php
$q = $pdo->prepare("SELECT * FROM tbl_setting WHERE id=1");
$q->execute();
$result = $q->fetchAll();
foreach ($result as $row) {
    $logo = $row['logo'];
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Settings - Logo</h1>
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
                            <label for="" class="col-sm-2 control-label">Existing Logo</label>
                            <div class="col-sm-4" style="background: #eee;padding:10px;">
                                <img src="uploads/<?php echo $logo; ?>" style="height:80px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Change Logo <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="file" name="photo" style="padding-top:6px;">
                            </div>
                        </div>                        
                        
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>