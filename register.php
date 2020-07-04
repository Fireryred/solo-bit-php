<?php 
	require_once 'template/heading.php';
	require_once 'template/navbar-guest.php';
?>
	<div class="container">
		<div class="card">
			<div class="card-body">
				<form class="form-signin" method="post" action="register-proccess.php">
					<h4>Register</h4>
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
					</div>
					<div class="form-group">
						<label for="email">Email Address</label>
						<input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
					</div>
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
					<?php 
						if (isset($_GET['error'])) {
							echo "<div class=\"alert alert-danger\">".$_GET['error']."</div>";
						}
					?>
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