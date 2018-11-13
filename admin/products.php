<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/shopApp/php/connect.php';
include 'include/head.php';
include 'include/navigation.php';

//the if will help add producteg if the button is clicked an action happen else it shows the list
if (isset($_GET['add'])) {
	$brandQuery = $dbcon -> query("SELECT * FROM brand ORDER BY brand");
	$parentQuery = $dbcon -> query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
	$priceQuery = $dbcon -> query("SELECT * FROM products");

if($_POST){
	$errors = array();
	if (!empty($_POST['sizes'])) {
		$sizeString = sanitize($_POST['sizes']);
		$sizeString = rtrim($sizeString,','); echo $sizeString; //get rid of the comma end the line
		$sizesArray = explode(',', $sizeString);
		$sArray = array();
		$qArray = array();
		foreach ($sizesArray as $ss) {
			$s = explode(':', $ss);
			$sArray[] = $s[0];
			$qArray[] = $s[1];
		}
	}else{
		$sizesArray = array();
	}


	$required = array('title','brand','price','parent','child','sizes');

	foreach ($required as $field) {
		if ($_POST[$field] == '') {
			$errors[] = 'All fields with an Astrisk are required.';
			break;
		}
	}

	if (!empty($_FILES)) {
		var_dump($_FILES);
		$photo = $_FILES['photo'];
		$name = $photo['name'];
		$nameArray = explode('.', $name);
		$fileName = $nameArray[0];
		$fileExt = $nameArray[1];
		$mime = explode('/', $photo['type']);
		$mimeType = $mime[0];
		$mimeExt = $mime[1];
		$tmpLoc = $photo['tmp_name'];
		$fileSize = $photo['size'];
		$allowed = array('png','jpg','jpeg','gif');
		if ($mimeType != 'image') {
			$errors[] = 'The file must be an image.';
		}
		if (!in_array($fileExt, $allowed)) {
			$errors[] = 'The file extension must be: png, jpg, jpeg, or gif';
		}
		if ($fileSize > 1000000) {
			$errors[] = 'The file size must be under 15mb';
		}
		if ($fileExt != $mimeExt && ($mimeExt == 'jpeg' &&$fileExt != 'jpg')) {
			$errors[] = 'File extension does noe match the file';
		}

	}
	if (!empty($errors)) {
		echo display_errors($errors);
	}else{
		//upload files and insert into database
	}
}

?>

<h2 class="text-center">Add a New Product</h2> <hr>

<form action="products.php?add=1" method="POST" enctype="multipart/form-data">
	<div class="form-group col-md-3">
		<label for="title">Title*:</label>
		<input type="text" name="title" class="form-control" id="title" value="<?=((isset($_POST['title']))?sanitize($_POST['title']):'');?>">
	</div>
	<div class="form-group col-md-3">
		<label for="brand">Brand*:</label>
		<select class="form-control" id="brand" name="brand">
			<option value=""<?=((isset($_POST['brand']) && $_POST['brand'] == '')?' selected':''); ?>></option>
			<?php while($brand = mysqli_fetch_assoc($brandQuery)): ?>
			<option value="<?=$brand['id']; ?>"<?=((isset($_POST['brand']) && $_POST['brand'] == $brand['id'])?' selected':'');?>><?=$brand['brand']; ?></option>
		<?php endwhile; ?>
		</select>
	</div>
	<div class="form-group col-md-3">
		<label for="parent">Parent Category*:</label>
		<select class="form-control" id="parent" name="parent">
			<option value=""<?=((isset($_POST['parent']) && $_POST['parent'] == '')?' selected':'');?>>
			</option>
			<?php while($parent = mysqli_fetch_assoc($parentQuery)): ?>
				<option value="<?=$parent['id']; ?>"<?=((isset($_POST['parent']) && $_POST['parent'] == $parent['id'])? ' select':'');?>> <?=$parent['category']; ?> </option>
			<?php endwhile; ?>
		</select>
	</div>
	<div class="form-group col-md-3">
		<label for="child">Child Category*:</label>
		<select id="child" name="child" class="form-control"> 
		<!-- the select option is pushed from the child_categories.php	 -->
		</select>
	</div>
	<div class="form-group col-md-3">
		<label for="price">Price*:</label>
		<input type="text" id="price" name="price" class="form-control" value="<?=((isset($_POST['price']))?sanitize($_POST['price']):'');?>">
	</div>
	<div class="form-group col-md-3">
		<label for="price">List Price:</label>
		<input type="text" id="list_price" name="list_price" class="form-control" value="<?=((isset($_POST['list_price']))?sanitize($_POST['list_price']):'');?>">
	</div>
	<div class="form-group col-md-3">
		<label >Quantity & Sizes*:</label>
		<button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Size</button>
	</div>
	<div class="form-group col-md-3">
		<label for="sizes">Sizes & Qty Preview</label>
		<input class="form-control" type="text" name="sizes" id="sizes" value="<?=((isset($_POST['sizes']))?$_POST['sizes']:'');?>" readonly>
	</div>
	<div class="form-group col-md-6">
		<label for="photo">Product Photo</label>
		<input type="file" name="photo" id="photo" class="form-control">
	</div>
	<div class="form-group col-md-6">
		<label for="description">Description</label>
		<textarea class="form-control" id="description" name="description" rows="6"><?=((isset($_POST['description']))?sanitize($_POST['description']):'');?></textarea>
	</div>
	<div class="col-md-9"></div>
	<div class="form-group col-md-3 pull-right">
	<input type="submit" class="form-control btn btn-success" value="Add Product" name="">
	</div>
	<div class="clearfix"></div>
</form>

<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="sizesModalLabel"> Sizes & Quantity</h4>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<?php for($i=1; $i<= 12; $i++): ?>
						<div class="form-group col-md-4">
							<label for="size<?=$i;?>">Size:</label>
							<input type="text"  id="size<?=$i;?>" name="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
						</div>
						<div class="form-group col-md-2">
							<label for="qty<?=$i;?>">Quantity:</label>
							<input type="number"  id="qty<?=$i;?>" qty="size<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">
						</div>
					<?php endfor; ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
			</div>
		</div>
	</div>
</div>


<?php }else{
$sql = "SELECT * FROM products WHERE deleted = 0";
$presults = $dbcon -> query($sql);
if (isset($_GET['featured'])) {
	$id =(int)$_GET['id'];
	$featured = (int)$_GET['featured'];
	$featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
	$dbcon -> query($featuredSql);
	header('Location: products.php');
}

 ?>

 <h2 class="text-center">Products</h2>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Product</a><div class="clearfix"></div>
 <hr>

 <table class="table table-borbered table-condensed table-striped">
 	<thead><th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th></thead>
 	<tbody>
 		<?php 
 			while($product = mysqli_fetch_assoc($presults)): 
 			$childID = $product['categories'];
 			$catSql = "SELECT * FROM categories WHERE id = '$childID'";
 			$result = $dbcon -> query($catSql);
 			$child = mysqli_fetch_assoc($result);
 			$parentID = $child['parent'];
 			$pSql = "SELECT * FROM categories WHERE id = '$parentID'";
 			$presult = $dbcon -> query($pSql);
 			$parent = mysqli_fetch_assoc($presult);
 			$category = $parent['category'].'-' .$child['category'];

 			?>
 			<tr>
 				<td>
 					<a href="products.php?edit=<?=$product['id']; ?>" class="btn btn-xs btn-default">Edit</a>
 					<a href="products.php?delete=<?=$product['id']; ?>" class="btn btn-xs btn-default">Delete</a>
 				</td>
 				<td><?=$product['title']; ?></td>
 				<!-- any of this two for the price -->
 				<td><?=money($product['price']); ?></td>
 				<!-- <td><?="$", $product['price']; ?></td> -->

 				<td><?=$category; ?></td>
 				
 				<td><a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?> & id=<?=$product['id']; ?>"  class="btn btn-xs btn-default "><span class="glyphicon "><?=(($product['featured']==1)?'-':'+');?></span>
 					</a>
 					&nbsp <?=(($product['featured'] == 1)?'Featured Product':'');?>
 				</td>
 				<td>0</td>
 			</tr>
 		<?php endwhile; ?>
 	</tbody>
 </table>

 <?php }
include 'include/footer.php';
  ?>
