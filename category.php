<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Categories</h1>
	</div>
	<div class="content-header-right">
		<a href="category-add.php" class="btn btn-primary btn-sm">Add New</a>
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
			        <th>SL</th>
			        <th>Category</th>
			        <th>Action</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$q = $pdo->prepare("
                            SELECT * 
                            FROM tbl_category 
                            ORDER BY category_name ASC
                        ");
                $q->execute();
                $res = $q->fetchAll();
            	foreach ($res as $row) {
            		$i++;
            		?>
					<tr>
	                    <td><?php echo $i; ?></td>
	                    <td><?php echo $row['category_name']; ?></td>
	                    <td>
	                        <a href="<?php echo BASE_URL; ?>category-edit.php?id=<?php echo $row['category_id']; ?>" class="btn btn-warning btn-xs">Edit</a>
                            <a href="<?php echo BASE_URL; ?>category-delete.php?id=<?php echo $row['category_id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
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