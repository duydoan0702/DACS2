<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./view/style.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">
			<div class="signup">
				<form action="./controller/registerController.php" method="POST">
					<label for="chk" aria-hidden="true">Sign up</label>	
					<input type="text" name= "name" value="<?php echo isset($userName) ? htmlspecialchars($userName) : ''; ?>" placeholder="User name" required="">
					<input type="email" name="email" placeholder="Email" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<button name="signUp" type="submit">Sign up</button>
				</form>
			</div>

			<div class="login">
				<form action="./controller/loginController.php" method="POST">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="email" name="email" placeholder="Email" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<button name="logIn" type="submit">Login</button>
				</form>
			</div>
	</div>
</body>
</html>
