<?php 
	require_once '../php/connect.php';
	include 'include/head.php';	
	include 'include/navigation.php';

	//get brands from database
	$sql = "SELECT * FROM brand ORDER BY brand";
	$result = $dbcon->query($sql);
	$errors = array();


	//Edit Brand
	if (isset($_GET['edit']) && !empty($_GET['edit'])) {
		$edit_id = (int)$_GET['edit'];
		$edit_id = sanitize($edit_id);
		// testing it : echo $edit_id;
		$sql2 = "SELECT * FROM brand WHERE id = '$edit_id'";
		$edit_result = $dbcon -> query($sql2);
		$ebrand = mysqli_fetch_assoc($edit_result); 
	}


	//Delete a brand
	if (isset($_GET['delete']) && !empty($_GET['delete'])) {
		$delete_id = (int)$_GET['delete'];
		$delete_id = sanitize($delete_id);
		// to test we do : echo $delete_id;

		//now the sql statement
		$sql = "DELETE FROM brand WHERE id = '$delete_id'";
		$dbcon -> query($sql);
		header('Location: brand.php');
	}

	//if a form is submitted and adding the sanitize fuction to reject unautorize input
	if (isset($_POST['add_submit'])) {
		$brand = sanitize($_POST['brand']);
		//check if brand is empty
		if ($_POST['brand'] == '') {
			$errors[] .= 'You Must Enter Brand'; 
		} 
		//check if brand exit in database
		$sql = "SELECT * FROM brand WHERE brand = '$brand' ";
		if (isset($_GET['edit'])) {
			$sql = "SELECT * FROM brand WHERE brand = '$brand' AND id != '$edit_id'";
		}
		$result = $dbcon->query($sql);
		$count = mysqli_num_rows($result);
		if ($count > 0) {
			$errors[] .= $brand.'That Brand already Exit. Choose another Name...';
		}
		//display error
		if (!empty($errors)) {
			echo display_errors($errors);
		}
		else{
			//add brand to database
			$sql = "INSERT INTO brand (brand) VALUES ('$brand')";
			if (isset($_GET['edit'])) {
				$sql = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
			}
			$dbcon -> query($sql);
			header('Location: brand.php');
		}
	}
 ?>

 <h2 style="text-align: center;" class="text-center">Brand</h2>
 <hr>

<!-- form to add brand -->
<!-- the php code in the action is a short form of if statement -->
<div class="text-center">
	<form class="form-inline" action="brand.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
		<div class="form-group">
			<?php
			$brand_value = '';
			 if (isset($_GET['edit'])) {
				$brand_value = $ebrand['brand'];
			} else{
				if (isset($_POST['brand'])) {
					$brand_value = sanitize($_POST['brand']);
				}
			} ?>
			<!-- add or edit a brand to show on page-->
			<label for="brand"><?=((isset($_GET['edit']))?'Edit':'Add A');?> Brand:</label>
			<input type="text" name="brand" id="brand" class="form-control" value="<?php echo $brand_value;?>">
			<!-- Adding a cancel button -->
			<?php if(isset($_GET['edit'])): ?>
				<a href="brand.php" class="btn btn-default">Cancel</a>
			<?php endif; ?>
			<input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit':'Add ');?>  Brand" class="btn btn-success">
		</div>
	</form>
</div>
<hr>

 <table class="table table-bordered table-striped table-auto table-condensed"> 
 	<thead>
 		<th></th>
 		<th>Brand</th>
 		<th></th> 
 	</thead>
 	<tbody>
 		<?php while($brand = mysqli_fetch_assoc($result)): ?>
 		<tr>
 			<td><a href="brand.php?edit=<?php echo $brand['id'];?>" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-pencil">Edit</span></a></td>
 			<td><?php echo $brand['brand']; ?></td>
 			<td><a href="brand.php?delete=<?php echo $brand['id'];?>" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-remove-sign">Delete</span></a></td>
 		</tr>
 	<?php endwhile; ?>
 	</tbody>
 </table>

 <?php 
 include 'include/footer.php';
  ?>