<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
if(isset($_POST['form1'])) {

    $statement = $pdo->prepare("UPDATE tbl_setting SET send_email_from=?,receive_email_to=?,smtp_host=?,smtp_port=?,smtp_username=?,smtp_password=? WHERE id=1");
    $statement->execute(array($_POST['send_email_from'],$_POST['receive_email_to'],$_POST['smtp_host'],$_POST['smtp_port'],$_POST['smtp_username'],$_POST['smtp_password']));

    $success_message = 'Email setting is updated successfully.';
}
?>

<?php
$q = $pdo->prepare("SELECT * FROM tbl_setting WHERE id=1");
$q->execute();
$result = $q->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $send_email_from = $row['send_email_from'];
    $receive_email_to = $row['receive_email_to'];
    $smtp_host = $row['smtp_host'];
    $smtp_port = $row['smtp_port'];
    $smtp_username = $row['smtp_username'];
    $smtp_password = $row['smtp_password'];
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Settings - Email</h1>
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
                            <label for="" class="col-sm-3 control-label">Send Email From</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="send_email_from" value="<?php echo $send_email_from; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Receive Email To</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="receive_email_to" value="<?php echo $receive_email_to; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">SMTP Host</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="smtp_host" value="<?php echo $smtp_host; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">SMTP Port</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="smtp_port" value="<?php echo $smtp_port; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">SMTP Username</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="smtp_username" value="<?php echo $smtp_username; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">SMTP Password</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="smtp_password" value="<?php echo $smtp_password; ?>">
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