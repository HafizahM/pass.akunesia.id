<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Groups</h1>
	</div>
	<div class="content-header-right">
		<a href="group-add.php" class="btn btn-primary btn-sm">Add New</a>
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
                    <th>Group Name</th>
                    <th>Available Users</th>
                    <th>Status</th>
                    <th>Action</th>
			    </tr>
			</thead>
            <tbody>

				<?php
                    $i=0;
                    $q = $pdo->prepare("
                                SELECT * 
                                FROM tbl_group
                            ");
                    $q->execute();
                    $res = $q->fetchAll();
                    foreach ($res as $row) {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['group_name']; ?></td>
                            <td>
                                <?php
                                $j=0;
                                $r = $pdo->prepare("SELECT *
                                                    FROM tbl_user_group t1
                                                    JOIN tbl_user t2
                                                    ON t1.user_id = t2.id 
                                                    WHERE t1.group_id=?");
                                $r->execute(array($row['group_id']));
                                $result1 = $r->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result1 as $row1) {
                                    $j++;
                                    if($j==1) {
                                        echo $row1['fname'].' '.$row1['lname'];
                                    } else {
                                        echo '<br>'.$row1['fname'].' '.$row1['lname'];
                                    }
                                }
                                ?>
                            </td>
                            <td><?php echo $row['group_status']; ?></td>
                            <td>
                                <a href="group-edit.php?id=<?php echo $row['group_id']; ?>" class="btn btn-warning btn-xs">Edit</a>
                                <a href="group-delete.php?id=<?php echo $row['group_id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>

            </tbody>
          </table>
        </div>
      </div>
  

</section>

<?php require_once('footer.php'); ?>