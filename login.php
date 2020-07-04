<?php
	if ($_SERVER['HTTPS'] != 'on') {
		header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		exit;
	}
	require_once 'template/heading.php';
	require_once 'template/navbar-guest.php';
?>
	<div class="container">
		<div class="card">
			<div class="card-body">
				<form class="form-signin" method="post" action="login-proccess.php">
					<h4>Login</h4>
					<?php
						$username = isset($_COOKIE['username']) ? $_COOKIE['username'] : null;
						$password = isset($_COOKIE['password']) ? $_COOKIE['password'] : null;
						$rememberMe = isset($_COOKIE['rememberMe']) ? $_COOKIE['rememberMe'] : null;
					?>
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" name="username" id="username" value="<?=$username?>" class="form-control" placeholder="Username" required autofocus>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" value="<?=$password?>" class="form-control" placeholder="Password" required>
					</div>
					<?php 
						if (isset($_GET['error'])) {
							echo "<div class=\"alert alert-danger\">".$_GET['error']."</div>";
						}
					?>
					<div class="form-check">
						<input type="checkbox" class="form-check-input" name="rememberMe" <?=isset($rememberMe) ? 'checked' : ''?>>
						<label class="form-check-label">Remember Me</label>
					</div>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
				</form>
				<div>
					<span>No account yet? Click <a href="register.php" class="btn-link">here</a> to register</span>
				</div>
			</div>
		</div>
	</div>
<?php 
	require_once 'template/footing.php';
?>