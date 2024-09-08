<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['title_website'])) {
        $valid = 0;
        $error_message .= 'Website Title can not be empty<br>';
    }

    if(empty($_POST['title_login'])) {
        $valid = 0;
        $error_message .= 'Login Page Title can not be empty<br>';
    }

    if($valid == 1) {

        // updating into the database
        $statement = $pdo->prepare("UPDATE tbl_setting SET title_website=?,title_login=? WHERE id=1");
        $statement->execute(array($_POST['title_website'],$_POST['title_login']));

        $success_message = 'General setting is updated successfully.';
    }
}
?>

<?php
$q = $pdo->prepare("SELECT * FROM tbl_setting WHERE id=1");
$q->execute();
$result = $q->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $title_website = $row['title_website'];
    $title_login = $row['title_login'];
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Settings - General</h1>
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

            <form class="form-horizontal" action="" method="post">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Website Title <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="title_website" maxlength="255" autocomplete="off" value="<?php echo $title_website; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Login Page Title <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="title_login" maxlength="255" autocomplete="off" value="<?php echo $title_login; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
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