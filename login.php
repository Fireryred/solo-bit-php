<?php
	session_start();
	if (@$_SESSION['username'] != null) {
		header('Location: index.php');
	}
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
				<form class="form-signin" method="post" action="login-process.php">
					<h4>Login</h4>
					<?php 
						$error = [];
						array_push($error, @$_SESSION['error']);
						if (@in_array("Username not exists", $error)) {
							echo "
							<div class=\"form-group\">
								<label for=\"username\">Username</label>
								<input type=\"text\" name=\"username\" id=\"username\" class=\"form-control is-invalid\" placeholder=\"Username\" required autofocus>
								<div class=\"invalid-feedback\">Username does not exist</div>
							</div>";
						} else {
							echo "
							<div class=\"form-group\">
								<label for=\"username\">Username</label>
								<input type=\"text\" name=\"username\" id=\"username\" class=\"form-control\" placeholder=\"Username\" required autofocus>
							</div>
							";
						}
						if (@in_array("Password wrong", $error)) {
							echo "
							<div class=\"form-group\">
								<label for=\"password\">Password</label>
								<input type=\"password\" name=\"password\" id=\"password\" class=\"form-control is-invalid\" placeholder=\"Password\" required>
								<div class=\"invalid-feedback\">Incorrect Password</div>
							</div>
							";
						} else {
							echo "
							<div class=\"form-group\">
								<label for=\"password\">Password</label>
								<input type=\"password\" name=\"password\" id=\"password\" class=\"form-control\" placeholder=\"Password\" required>
							</div>
							";
						}
						session_destroy();
					?>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
				</form>
				<div>
					<span>Not Registered? Click <a href="register.php" class="btn-link">here</a> to register</span>
				</div>
			</div>
		</div>
	</div>
<?php 
	require_once 'template/footing.php';
?>