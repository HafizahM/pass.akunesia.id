<?php require_once('header.php'); ?>

<?php admin_check(); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Users</h1>
	</div>
	<div class="content-header-right">
		<a href="user-add.php" class="btn btn-primary btn-sm">Add New</a>
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
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Email Address</th>
                    <th>Phone</th>
                    <th>Photo</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
			    </tr>
			</thead>
            <tbody>

				<?php
                $i=0;
                $q = $pdo->prepare("
                            SELECT * 
                            FROM tbl_user
                        ");
                $q->execute();
                $res = $q->fetchAll();
                foreach ($res as $row) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['fname']; ?></td>
                        <td><?php echo $row['lname']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td>
                            <img src="uploads/<?php echo $row['photo']; ?>" alt="user photo" style="width:100px;">
                        </td>
                        <td><?php echo $row['role']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <?php if($i!=1): ?>
                            <a href="user-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-xs">Edit</a>
                            <a href="user-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                            <?php endif; ?>
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