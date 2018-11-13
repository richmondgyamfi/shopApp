
<?php
	require_once 'php/connect.php'; 
	$id = $_POST['id'];
	$id = (int)$id;
	$sql = "SELECT * FROM products WHERE id = '$id'";
	$result = $dbcon->query($sql);
	$product = mysqli_fetch_assoc($result);
	$brand_id = $product['brand'];
	$sql2 = "SELECT brand FROM brand WHERE id = '$brand_id'";
	$brandquery = $dbcon->query($sql2);
	$brand = mysqli_fetch_assoc($brandquery);
	$sizes = $product['sizes'];
	$size_array = explode(',', $sizes);
 ?>

<?php ob_start(); ?>

<div class="modal fade details-1" id="details_modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" onclick="closeModal()" aria-label="close">
				<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><?php echo $product['title']; ?></h4>
			</div>
			<!-- <?php var_dump($size_array); ?> -->
			<hr>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6">
							<div class="center-block">
								<img  width="auto" height="220" src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>" class="mydetails details img-responsive" />
							</div>
						</div>
						<!-- <div class="col-md-2"></div> -->
						<div class="col-md-6">
							<h4> Details</h4>
							<p> <?php echo $product['description']; ?></p>
							<p> Price: <?php echo $product['price']; ?></p>
							<p>Brand: <?php echo $brand['brand']; ?> </p>
							<hr>
							<form action="addtoCart.php" method="post">
								<div class="form-group">
									<div class="col-xs-3">
										<label for="quantity">Quantity:</label>
										<input type="text" class="form-control" id="quantity" name="quantity">
									</div><div class="col-xs-9"></div>
								</div><br><br>
								<div class="form-group">
									<label for="size">Size:</label>
									<select name="size" id="size" class="form-control">
										<option value=""></option>
										<?php foreach ($size_array as $string) {
											$string_array = explode(':', $string);
											$size = $string_array[0];
											$quantity = $string_array[1];
											echo '<option value="'.$size.'">'.$size.' ('.$quantity.' Available)</option>';
										} ?>
									</select>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" onclick="closeModal()">Close</button>
				<button class="btn btn-warning" type="submit"> <span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart</button>
			</div>
		</div>
	</div>
</div>
<script>
	function closeModal(){
		jQuery('#details_modal').modal('hide');
		setTimeout(function(){
			jQuery('#details_modal').remove();
			jQuery('.modal_backdrop').remove();
		},300);
	}
</script>
<?php echo ob_get_clean(); ?>