<div class="navbar navbar-expand navbar-dark bg-dark sticky-top">
	<a href="index.php" class="navbar-brand">Solo Bit</a>
	<div class="collapse navbar-collapse">
		<ul class="navbar-nav mr-auto">
		</ul>
		<form class="form-inline my-2 my-lg-0" action="search-process.php">
			<input class="form-control mr-sm-2" type="search" name="product" placeholder="Search">
			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		</form>
		<span class="dropdown">
			<a href="" class="nav-link text-light dropdown-toggle" data-toggle="dropdown"><?=$_SESSION['username']?></a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="" class="dropdown-item">Account</a>
				<a href="" class="dropdown-item">Checkout</a>
				<a href="logout.php" class="dropdown-item">Logout</a>
			</div>
		</span>
	</div>
</div>