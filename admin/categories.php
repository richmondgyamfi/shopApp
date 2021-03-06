<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/shopApp/php/connect.php';
	include 'include/head.php';
	include 'include/navigation.php';

	$sql = "SELECT * FROM categories WHERE parent = 0";
	$result = $dbcon -> query($sql);
	$errors = array();
	$category = '';
	$post_parent = '';


	//edit category
	if (isset($_GET['edit']) && !empty($_GET['edit'])) {
		$edit_id = (int)$_GET['edit'];
		$edit_id = sanitize($edit_id);
		$edit_sql = "SELECT * FROM categories WHERE id = '$edit_id'";
		$edit_result = $dbcon -> query($edit_sql);
		$edit_category = mysqli_fetch_assoc($edit_result);

	}


	//Delete parent and child in category
	if (isset($_GET['delete']) && !empty($_GET['delete'])) {
		$delete_id = (int)$_GET['delete'];
		$delete_id = sanitize($delete_id);

		//delete child along with parent
		$sql = "SELECT * FROM categories WHERE id = '$delete_id'";
		$result = $dbcon -> query($sql);
		$dcategory = mysqli_fetch_assoc($result);
		if ($dcategory['parent'] == 0) {
			$sql = "DELETE FROM categories WHERE parent = '$delete_id'";
			$dbcon -> query($sql);
		}

		$dsql = "DELETE FROM categories WHERE id = '$delete_id'";
		$dbcon -> query($dsql);
		header('Location: categories.php');
	}

	//Process Form
	if (isset($_POST) && !empty($_POST)) {
		$post_parent = sanitize($_POST['parent']);
		$category = sanitize($_POST['category']);

		$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent'";

		if (isset($_GET['edit'])) {
			$id = $edit_category['id'];
			$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' AND id != 'id'";
		}

		$fresult = $dbcon -> query($sqlform);
		$count = mysqli_num_rows($fresult);

		//if category is blank
		if ($category == '') {
			$errors[] .= 'The category is blank. ';
		}

		//check if exit in database
		if ($count > 0) {
			$errors[] .= $category. ' Already exists. Please choose a new category.';
		}

		//Display errors or update Database
		if (!empty($errors)) {
			//display errors
			$display = display_errors($errors); ?>
			<script>
				jQuery('document').ready(function(){
					jQuery('#errors').html('<?=$display; ?>');
				})
			</script>

		<?php }
			else{
				//Update Database
				$updatesql = "INSERT INTO categories (category, parent) VALUES ('$category','$post_parent')";
				//editing a category
				if (isset($_GET['edit'])) {
					$updatesql = "UPDATE categories SET category = '$category', parent = '$post_parent' WHERE id = '$edit_id'";
				}
				$dbcon -> query($updatesql);
				header('Location: categories.php');
			}
	}

	$category_value = '';
	$parent_value = 0;
	if (isset($_GET['edit'])) {
		$category_value = $edit_category['category'];
		$parent_value = $edit_category['parent'];
	}else{
		if (isset($_POST['category'])) {
			$category_value = $category;
			$parent_value = $post_parent;

			// $category_value = sanitize($_POST['category']);
		}
	}
 ?> 

<h2 class="text-center">Categories</h2><hr> 

<div class="row">
	<!-- Form -->
	<div class="col-md-6">
		<!-- <?=((isset($_GET['edit']))?'?edit'.$edit_id:'');?> This is a turnary operator; it changes according to the operation to perform -->
		<form class="form" action="categories.php<?= ((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
			<legend> <?php echo ((isset($_GET['edit']))?'Edit':'Add A');?> Category</legend><hr>
			<div id="errors">
				
			</div>
			<div class="form-group">
				<?php
			$category_value = '';
			 if (isset($_GET['edit'])) {
				$category_value = $edit_category['category'];
			} else{
				if (isset($_POST['category'])) {
					$category_value = sanitize($_POST['category']);
				}
			} ?>

				<label for="parent">Parent</label>
				<select class="form-control" name="parent" id="parent">
					<option value="0" <?php echo (($parent_value == 0)?' selected="selected"':''); ?>>  Parent</option>
					<?php while($parent = mysqli_fetch_assoc($result)): ?>
						<option value=" <?php echo $parent['id'];?>"<?=(($parent_value == $parent['id'])?' selected="selected"':''); ?>>
							<?php echo $parent['category']; ?>
						</option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="category">Category</label>
				<input type="text" class="form-control" id="category" name="category" value="<?php echo $category_value; ?>">
			</div>
			<div class="form-group">
				<input type="submit"  value="<?php echo ((isset($_GET['edit']))?'Edit ':'Add ');?> Category" class="btn btn-success">
			</div>
		</form>
	</div>

	<!-- The category table -->
	<div class="col-md-6">
		<table class="table table-bordered table-striped">
			<thead>
				<th>Categories</th>
				<th>Parent</th>
				<th></th> 
			</thead>
			<tbody>
				<?php 
					$sql = "SELECT * FROM categories WHERE parent = 0";
					$result = $dbcon -> query($sql);
				while($parent = mysqli_fetch_assoc($result)):
					$parent_id = (int)$parent['id'];
					$sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
					$cresult = $dbcon -> query($sql2);
				?>
				<tr class="bg-primary">
					<td><?php echo $parent['category']; ?></td>
					<td>Parent</td>
					<td>
						<a href="categories.php?edit=<?php echo $parent['id'];?>" class="btn btn-xs btn-default">Edit</a>
						<a href="categories.php?delete=<?php echo $parent['id'];?>" class="btn btn-xs btn-default">Delete</a>
					</td>
				</tr>
				<?php while ($child = mysqli_fetch_assoc($cresult)):?>
					<tr class="bg-info">
					<td><?php echo $child['category']; ?></td>
					<td><?php echo $parent['category']; ?></td>
					<td>
						<a href="categories.php?edit=<?php echo $child['id'];?>" class="btn btn-xs btn-default">Edit</a>
						<a href="categories.php?delete=<?php echo $child['id'];?>" class="btn btn-xs btn-default">Delete</a>
					</td>
				</tr>
				<?php endwhile; ?>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>

 <?php 
 	include 'include/footer.php';
  ?>