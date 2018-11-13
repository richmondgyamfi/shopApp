<!DOCTYPE html>
<html>
<head>
	<title>DG Ent.</title>
	<link rel="icon" type="image/gif" href="img/dglogo.png" sizes="16x16">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
	 <?php 
		include 'header.php';
	 ?>
		<div class="log-id">
			<div class="loginid container2">
				<form action="goto.php" style="border:1px solid #ccc">
					  <div class="container">
					    <h2 style="text-align: center">Sign Up</h2>
						<hr>
					    <p>Please fill in this form to create an account.</p>
					    <hr>
					     <label for="firstname"><b>Firstname</b></label><br>
					    <input type="text" placeholder="Firstname" name="firstname" required>
					    <br><br>

					     <label for="lastname"><b>Lastname</b></label><br>
					    <input type="text" placeholder="Lastname" name="lastname" required>
					    <br><br>

					    <label for="username"><b>Username</b></label><br>
					    <input type="text" placeholder="Username" name="username" required>
					    <br><br>

					    <label for="email"><b>Email</b></label><br>
					    <input type="text" placeholder="Enter Email" name="email" required>
					    <br><br>

					    <label for="psw"><b>Password</b></label><br>
					    <input type="password" placeholder="Enter Password" name="psw" required>
					    <br><br>

					    <label for="psw-repeat"><b>Repeat Password</b></label><br>
					    <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
					    <br><br>
					    
					    <label>
					      <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
					    </label>
					    
					    <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

					    <div class="clearfix">
					      <button type="button" class="cancelbtn">Cancel</button>
					      <button type="submit" class="signupbtn">Sign Up</button>
					    </div>
					    <div><p>All ready user?<a href="loginpage.php">Login</a></p></div>
					  </div>
				</form>
			</div>
		</div>
</body>
</html>