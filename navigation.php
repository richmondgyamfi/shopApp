<?php 
	$sql = "SELECT * FROM categories WHERE parent = 0";
	$pquery = $dbcon->query($sql);
 ?>


<div class="container-fluid navbar navbar-dark bg-inverse bg-faded navbar-fixed-top">
	<nav class="container  ">
		<nav class=" container">
		  <ul class="nav navbar-nav  lead">
		    <li class="nav-item active">
		      <a class="nav-link" href="index.php"><span class="text-danger">the</span>ShopApp</a>
		    </li>
		  </ul>
		   <button class="navbar-toggler hidden-sm-up menuleft btn-inverse active" type="button" data-toggle="collapse" data-target="#navbar-header" aria-controls="navbar-header">
		     <span class="bars">&#9776;</span>
		   </button>
		   <div class="collapse navbar-toggleable-xs" id="navbar-header">
		     <ul class="nav navbar-nav form-inline pull-xs-right lead">
		     	<?php while ($parent = mysqli_fetch_assoc($pquery)) : ?>
		     		<?php 
		     		$parent_id = $parent['id']; 
		     		$sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
		     		$cquery = $dbcon->query($sql2);
		     		?>
		       <li class="nav-item dropdown">
		         <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $parent['category']; ?>&nbsp;<span class="caret"></span></a>
		         <ul class="dropdown-menu" role="menu">
		         	<?php while($child = mysqli_fetch_assoc($cquery)) : ?>
		         	<li><a href="#"><?php echo $child['category']; ?></a></li>
		         <?php endwhile; ?>
		         </ul>
		       </li>
		   <?php endwhile; ?>
		     </ul>
		   </div>
		</nav> <!-- /navbar -->
	</nav>
</div>