<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<?php
$q = $pdo->prepare("SELECT * FROM tbl_setting WHERE id=1");
$q->execute();
$result = $q->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $website_email = $row['email'];
}
?>

<?php
if(isset($_POST['form1'])) {

    $valid = 1;

    $mail_subject = strip_tags($_POST['mail_subject']);
    $mail_body = strip_tags($_POST['mail_body']);

    if(empty($mail_subject)) {
        $valid = 0;
        $error_message .= "Mail Subject can not be empty\\n";
    }

    if(empty($mail_body)) {
        $valid = 0;
        $error_message .= "Mail Body can not be empty\\n";
    }

    if(!isset($_POST['group_ids'])) {
        $valid = 0;
        $error_message .= "You must have to select a group\\n";
    }

    if($valid == 1) {

        $q = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_mail_group'");
        $q->execute();
        $result = $q->fetchAll();
        foreach($result as $row) {$ai_id=$row[10];}

        $mail_date_time = date('Y-m-d H:i:s');

        // Saving data into tbl_mail_group
        $q = $pdo->prepare("INSERT INTO tbl_mail_group (mail_subject,mail_body,mail_date_time) VALUES (?,?,?)");
        $q->execute(array($mail_subject,$mail_body,$mail_date_time));

        // Saving data into tbl_mail_group_all
        foreach($_POST['group_ids'] as $val) {
            $q = $pdo->prepare("INSERT INTO tbl_mail_group_all (mail_id,group_id) VALUES (?,?)");
            $q->execute(array($ai_id,$val));
        }

        // Send Email
        try {
            $mail->setFrom($website_email, 'Admin');

            // Getting all unique user ids from group array
            $arr_user_id = array();
            foreach($_POST['group_ids'] as $val) {
                $q = $pdo->prepare("SELECT * FROM tbl_user_group WHERE group_id=?");
                $q->execute(array($val));
                $result = $q->fetchAll();
                foreach ($result as $row) {
                    $arr_user_id[] = $row['user_id'];
                }
            }
            $arr_user_id = array_values(array_unique($arr_user_id));


            for($i=0;$i<count($arr_user_id);$i++) {
                $q = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
                $q->execute(array($arr_user_id[$i]));
                $result = $q->fetchAll();
                foreach ($result as $row) {
                    $user_email = $row['email'];
                    $user_name = $row['fname'].' '.$row['lname'];
                }
                $mail->addAddress($user_email, $user_name);
            }

            $mail->addReplyTo($website_email, 'Admin');

            $mail->isHTML(true);
            $mail->Subject = $mail_subject;

            $mail->Body = $mail_body;
            $mail->send();

            $success_message = 'Mail is sent successfully.';
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Send Mail to Group</h1>
	</div>
	<div class="content-header-right">
		<a href="all-mail-group.php" class="btn btn-primary btn-sm">View All Mails to Group</a>
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
                
                <?php $csrf->echoInputField(); ?>

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">To (Group) <span>*</span></label>
							<div class="col-sm-8">
								<select name="group_ids[]" class="form-control select2" multiple>
                                    <?php
                                    $q = $pdo->prepare("SELECT * FROM tbl_group ORDER BY group_name ASC");
                                    $q->execute();
                                    $result = $q->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <option value="<?php echo $row['group_id']; ?>"><?php echo $row['group_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Subject <span>*</span></label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="mail_subject" maxlength="255" autocomplete="off" value="">
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Message <span>*</span></label>
							<div class="col-sm-8">
								<textarea name="mail_body" class="form-control" cols="30" rows="10"></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-8">
								<button type="submit" class="btn btn-success pull-left" name="form1">Send</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>