<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Mail to User</h1>
	</div>
	<div class="content-header-right">
		<a href="send-mail-user.php" class="btn btn-primary btn-sm">Send Mail to User</a>
	</div>
</section>

<section class="content">

  <div class="row">
    <div class="col-md-12">

      <div class="box box-info">
        
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-striped">
			<thead>
			    <tr>
			        <th>Serial</th>
                    <th>Mail Subject</th>
                    <th>Mail Date & Time</th>
                    <th>Action</th>
			    </tr>
			</thead>
            <tbody>

				<?php
                $i=0;
                $q = $pdo->prepare("
                            SELECT * 
                            FROM tbl_mail_user
                            ORDER BY mail_id DESC
                        ");
                $q->execute();
                $res = $q->fetchAll();
                foreach ($res as $row) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['mail_subject']; ?></td>
                        <td><?php echo $row['mail_date_time']; ?></td>
                        <td>
                            <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">Details</a>
                            <a href="all-mail-user-delete.php?id=<?php echo $row['mail_id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                        </td>
                    </tr>
                    <div class="modal fade" id="myModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">View Details</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="rTable">
                                        <div class="rTableRow">
                                            <div class="rTableHead"><strong>Mail Subject</strong></div>
                                            <div class="rTableCell">
                                                <?php echo $row['mail_subject']; ?>
                                            </div>
                                        </div>
                                        <div class="rTableRow">
                                            <div class="rTableHead"><strong>Mail Body</strong></div>
                                            <div class="rTableCell">
                                                <?php echo nl2br($row['mail_body']); ?>
                                            </div>
                                        </div>
                                        <div class="rTableRow">
                                            <div class="rTableHead"><strong>Sent to (Users)</strong></div>
                                            <div class="rTableCell">
                                                <?php
                                                    $j=0;
                                                    $r = $pdo->prepare("SELECT * 
                                                                        FROM tbl_mail_user_all t1
                                                                        JOIN tbl_user t2
                                                                        ON t1.user_id = t2.id 
                                                                        WHERE t1.mail_id=?");
                                                    $r->execute(array($row['mail_id']));
                                                    $total = $r->rowCount();
                                                    $res1 = $r->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($res1 as $row1) {
                                                        $j++;
                                                        echo $j.'. '.$row1['fname'].' '.$row1['lname'].'<br>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </tbody>
          </table>
        </div>
      </div>
  

</section>

<?php require_once('footer.php'); ?>