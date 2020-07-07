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
				<form class="form-signin" method="post" action="register-process.php">
					<h4>Register</h4>
					<?php 
						session_start();
						$error = @$_SESSION['error'];
						if (isset($error)) {
							if (in_array("Username taken", $error)) {
								echo "
								<div class=\"form-group\">
									<label for=\"username\">Username</label>
									<input type=\"text\" name=\"username\" id=\"username\" class=\"form-control is-invalid\" placeholder=\"Username\" required autofocus>
									<div class=\"invalid-feedback\">Username is already taken</div>
								</div>
								";
 							} else {
								echo "
								<div class=\"form-group\">
									<label for=\"username\">Username</label>
									<input type=\"text\" name=\"username\" id=\"username\" class=\"form-control\" placeholder=\"Username\" required autofocus>
								</div>
								";
 							}
 							if (in_array("Password invalid", $error) || in_array("Username Password same", $error)) {
 								echo "
								<div class=\"form-group\">
									<label for=\"Password\">Password</label>
									<input type=\"password\" name=\"password\" id=\"password\" class=\"form-control is-invalid\" placeholder=\"Password\" required>
								";
								if (in_array("Password invalid", $error)) {
									echo "<div class=\"invalid-feedback\">Password must contain atleast: 1 uppercase, 1 lowercase and 1 number</div>";
								} else if (in_array("Username Password same", $error)) {
									echo "<div class=\"invalid-feedback\">Username must not exist in password</div>";
								}
								echo "
								</div>
								";
 							} else {
								echo "
								<div class=\"form-group\">
									<label for=\"Password\">Password</label>
									<input type=\"password\" name=\"password\" id=\"password\" class=\"form-control\" placeholder=\"Password\" required>
								</div>
								";
 							}
 							if (in_array("Password not same", $error)) {
								echo "
								<div class=\"form-group\">
									<label for=\"confirmPassword\">Password</label>
									<input type=\"password\" name=\"confirmPassword\" id=\"confirmPassword\" class=\"form-control is-invalid\" placeholder=\"Confirm Password\" required>
									<div class=\"invalid-feedback\">Confirm Password must be the same as Password</div>
								</div>
								";
 							} else {
								echo "
								<div class=\"form-group\">
									<label for=\"confirmPassword\">Password</label>
									<input type=\"password\" name=\"confirmPassword\" id=\"confirmPassword\" class=\"form-control\" placeholder=\"Confirm Password\" required>
								</div>
								";
 							}
 							if (in_array("Email invalid", $error)) {
								echo "
								<div class=\"form-group\">
									<label for=\"email\">Email Address</label>
									<input type=\"email\" name=\"email\" id=\"email\" class=\"form-control is-invalid\" placeholder=\"Email Address\" required>
									<div class=\"invalid-feedback\">Invalid Email</div>
								</div>
								";
 							} else {
								echo "
								<div class=\"form-group\">
									<label for=\"email\">Email Address</label>
									<input type=\"email\" name=\"email\" id=\"email\" class=\"form-control\" placeholder=\"Email Address\" required>
								</div>
								";
 							}
						} else {
							echo "
								<div class=\"form-group\">
									<label for=\"username\">Username</label>
									<input type=\"text\" name=\"username\" id=\"username\" class=\"form-control\" placeholder=\"Username\" required autofocus>
								</div>
								<div class=\"form-group\">
									<label for=\"password\">Password</label>
									<input type=\"password\" name=\"password\" id=\"password\" class=\"form-control\" placeholder=\"Password\" required>
								</div>
								<div class=\"form-group\">
									<label for=\"confirmPassword\">Password</label>
									<input type=\"password\" name=\"confirmPassword\" id=\"confirmPassword\" class=\"form-control\" placeholder=\"Confirm Password\" required>
								</div>
								<div class=\"form-group\">
									<label for=\"email\">Email Address</label>
									<input type=\"email\" name=\"email\" id=\"email\" class=\"form-control\" placeholder=\"Email Address\" required>
								</div>
								
							";
						}
						session_destroy();
					?>
						<div class="row form-group">
							<div class="col">
								<label for="firstName">First Name</label>
								<input type="text" name="firstName" id="firstName" class="form-control" placeholder="First Name" required>
							</div>
							<div class="col">
								<label for="middleName">Middle Name</label>
								<input type="text" name="middleName" id="middleName" class="form-control" placeholder="Middle Name">
							</div>
							<div class="col">
								<label for="lastName">Last Name</label>
								<input type="text" name="lastName" id="lastName" class="form-control" placeholder="Last Name" required>
							</div>
						</div>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
				</form>
				<div>
					<span>Already Registered? Click <a href="login.php" class="btn-link">here</a> to login</span>
				</div>
			</div>
		</div>
	</div>
<?php 
	require_once 'template/footing.php';
?>