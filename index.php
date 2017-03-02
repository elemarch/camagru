<?php include 'includes/header.php' ?>

<?php if ($connected) { ?>
	<div id="text-center">
    <h1>Already connected</h1>
			<ul>
				<li><a class="button" href="gallery.php">Gallery</a></li>
				<li><a class="button" href="perso.php">My Photos</a></li>
				<li><a class="button" href="creation.php">Create</a></li>
				<li><a class="button" href="creation.php">Disconnect</a></li>
			</ul>
    </div>
<?php } else { ?>
	<div class="col-3 text-center">
			<h1>Enter as Guest</h1>
			<ul>
				<li><a class="button" href="gallery.php">Gallery</a></li>
				<li><a class="button" href="single.php">Random</a></li>
			</ul>
	</div>
	<div class="col-3 col-middle text-center">
			<h1>Log In</h1>
			<form method="post" action="login.php" name="loginform" id="loginform">
				<label for="username">Username</label><br>
		  		<input type="text" name="username" id="username"><br>
				 <label for="password">Password</label><br>
				<input type="password" name="password" id="password"><br>
				<input type="submit" name="register" id="register" value="Log In">
			</form>
			<a href="forgot_password.php">I forgot my Password...</a>
	</div>
	<div class="col-3 text-center">
			<h1>Sign In</h1>
			 <form method="post" action="register.php" name="registerform" id="registerform">
				<label for="email">E-Mail</label><br>
		  		<input type="email" name="email" id="email"><br>
				<label for="username">Username</label><br>
		  		<input type="text" name="username" id="username"><br>
				 <label for="password">Password</label><br>
				<input type="password" name="password1" id="password1"><br>
				<input type="password" name="password2" id="password2"><br>
				<input type="submit" name="register" id="register" value="create account">
			</form>
	</div>

<?php } ?>

<?php include 'includes/footer.php' ?>