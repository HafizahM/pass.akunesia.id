<?php require_once('header.php'); ?>

<?php

$my_user_id = $_SESSION['user']['id'];

$my_group_ids = array();
$q = $pdo->prepare("SELECT * FROM tbl_user_group WHERE user_id=?");
$q->execute(array($my_user_id));
$result = $q->fetchAll();
foreach ($result as $row) {
    $my_group_ids[] = $row['group_id'];
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Items</h1>
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
                    <th style="width: 100px;">Action</th>
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
                    


                    // Checking in user table
                    $found_in_user_table = 0;
                    $r = $pdo->prepare("SELECT * FROM tbl_item_user WHERE item_id=? AND user_id=?");
                    $r->execute(array($row['item_id'],$my_user_id));
                    $total = $r->rowCount();
                    if($total)
                    {
                        $found_in_user_table = 1;
                    } else {
                        $found_in_user_table = 0;
                    }

                    // Checking in group table
                    $found_in_group_table = 0;
                    $r = $pdo->prepare("SELECT * FROM tbl_item_group WHERE item_id=?");
                    $r->execute(array($row['item_id']));
                    $res1 = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($res1 as $row1) {
                        if(in_array($row1['group_id'],$my_group_ids)) {
                            $found_in_group_table = 1;
                        } else {
                            $found_in_group_table = 0;
                        }
                    }
                    if( $found_in_user_table == 0 && $found_in_group_table == 0 ) {
                        continue;
                    }
                    $i++;
                    ?>
                    <tr>
                        <td style="width:100px;"><?php echo $i; ?></td>
                        <td style="width:300px;"><?php echo decr($row['name'],PRIVATE_KEY); ?></td>
                        <td style="word-break: break-all;width:350px;">
                            <?php echo decr($row['url'],PRIVATE_KEY); ?>
                        </td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td>
                            <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">View Details</a>
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