<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Items</h1>
	</div>
	<div class="content-header-right">
		<a href="item-add.php" class="btn btn-primary btn-sm">Add New</a>
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
                    <th>Name</th>
                    <th>URL</th>
                    <th>Category</th>
                    <th>Action</th>
			    </tr>
			</thead>
            <tbody>

				<?php
                $i=0;
                $q = $pdo->prepare("
                            SELECT * 
                            FROM tbl_item t1
                            JOIN tbl_category t2
                            ON t1.category_id = t2.category_id
                            ORDER BY t1.item_id ASC
                        ");
                $q->execute();
                $res = $q->fetchAll();
                foreach ($res as $row) {
                    $i++;
                    ?>
                    <tr>
                        <td style="width:50px;"><?php echo $i; ?></td>
                        <td style="width:280px;"><?php echo decr($row['name'],PRIVATE_KEY); ?></td>
                        <td style="word-break: break-all;width:300px;">
                            <?php echo decr($row['url'],PRIVATE_KEY); ?>
                        </td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td style="width:170px;">
                            <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">Details</a>
                            <a href="item-edit.php?id=<?php echo $row['item_id']; ?>" class="btn btn-warning btn-xs">Edit</a>
                            <a href="item-delete.php?id=<?php echo $row['item_id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
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
                                            <div class="rTableHead"><strong>Name</strong></div>
                                            <div class="rTableCell">
                                                <?php echo decr($row['name'],PRIVATE_KEY); ?>
                                            </div>
                                        </div>
                                        <div class="rTableRow">
                                            <div class="rTableHead"><strong>URL</strong></div>
                                            <div class="rTableCell">
                                                <?php echo decr($row['url'],PRIVATE_KEY); ?>
                                            </div>
                                        </div>
                                        <div class="rTableRow">
                                            <div class="rTableHead"><strong>Username</strong></div>
                                            <div class="rTableCell">
                                                <?php echo decr($row['username'],PRIVATE_KEY); ?>
                                            </div>
                                        </div>
                                        <div class="rTableRow">
                                            <div class="rTableHead"><strong>Password</strong></div>
                                            <div class="rTableCell">
                                                <?php echo decr($row['password'],PRIVATE_KEY); ?>
                                            </div>
                                        </div>
                                        <div class="rTableRow">
                                            <div class="rTableHead"><strong>Extra Information</strong></div>
                                            <div class="rTableCell">
                                                <?php echo nl2br(decr($row['extra_info'],PRIVATE_KEY)); ?>
                                            </div>
                                        </div>
                                        <div class="rTableRow">
                                            <div class="rTableHead"><strong>Category</strong></div>
                                            <div class="rTableCell">
                                                <?php echo $row['category_name']; ?>
                                            </div>
                                        </div>
                                        <div class="rTableRow">
                                            <div class="rTableHead"><strong>Users</strong></div>
                                            <div class="rTableCell">
                                                <?php
                                                $str1 = '';
                                                $j=0;
                                                $r = $pdo->prepare("SELECT *
                                                                    FROM tbl_item_user t1
                                                                    JOIN tbl_user t2
                                                                    ON t1.user_id = t2.id 
                                                                    WHERE t1.item_id=?");
                                                $r->execute(array($row['item_id']));
                                                $result1 = $r->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result1 as $row1) {
                                                    $j++;
                                                    if($j==1) {
                                                        $str1 .= $j.'. '.$row1['fname'].' '.$row1['lname'];
                                                    } else {
                                                        $str1 .= '<br>'.$j.'. '.$row1['fname'].' '.$row1['lname'];
                                                    }
                                                }
                                                echo $str1;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="rTableRow">
                                            <div class="rTableHead"><strong>Groups</strong></div>
                                            <div class="rTableCell">
                                                <?php
                                                $str2 = '';
                                                $j=0;
                                                $r = $pdo->prepare("SELECT *
                                                                    FROM tbl_item_group t1
                                                                    JOIN tbl_group t2
                                                                    ON t1.group_id = t2.group_id 
                                                                    WHERE t1.item_id=?");
                                                $r->execute(array($row['item_id']));
                                                $result1 = $r->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result1 as $row1) {
                                                    $j++;
                                                    if($j==1) {
                                                        $str2 .= $j.'. '.$row1['group_name'];
                                                    } else {
                                                        $str2 .= '<br>'.$j.'. '.$row1['group_name'];
                                                    }
                                                }
                                                echo $str2;
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