
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/shopApp/php/connect.php';

$parentID = (int)$_POST['parentID']; 
$childQuery = $dbcon -> query("SELECT * FROM categories WHERE parent = '$parentID' ORDER BY category ASC");

ob_start();
?>

<option value=""></option> 

<?php while($child = mysqli_fetch_assoc($childQuery)): ?>
	<option value="<?=$child['id']; ?>"><?=$child['category']; ?></option>
<?php endwhile; ?>

 


<!-- this echos the html code back to the data function in the footer page -->
 <?php echo ob_get_clean(); ?>

<?php 



 ?>

