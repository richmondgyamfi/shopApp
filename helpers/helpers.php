<?php 
	//fuctions to print errors on the screen
function display_errors($errors){
	$display = '<ul class= "bg-success">';
	foreach ($errors as $error) {
		$display .= '<li class="text-danger">' .$error.'</li>';
	}

	$display .= '</ul>';
	return $display;
 }

//function to stop unautorize adding to the brand

 function sanitize($dirty){
 	return htmlentities($dirty, ENT_QUOTES, "UTF-8");
 }

//creating a function for the price in the admin/products file
 function money ($number){
 	return '$'.number_format($number,2);
 }
?>