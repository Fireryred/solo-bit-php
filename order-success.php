<?php 
	session_start();
	require_once 'reference/properties.php';
	require_once 'template/heading.php';
	if (@$_SESSION['username'] != null) {
		require_once 'template/navbar-user.php';
	} else {
		header('Location: index.php');
	}
?>
<div class="container-fluid">
	<div class="card">
		<div class="card-body">
			<h1>Order is Successfull</h1>
			<a href="index.php" class="btn btn-primary">Go Back</a>
		</div>
	</div>
</div>
<?php
	require_once 'template/footing.php';
?>