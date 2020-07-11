<?php 
	session_start();
	require_once 'reference/properties.php';
	require_once 'template/heading.php';
	if (@$_SESSION['username'] != null) {
		require_once 'template/navbar-user.php';
	} else {
		require_once 'template/navbar-guest.php';
	}
?>
<div class="container-fluid">
	<div class="card">
		<div class="card-body">
			<?php
				$search = $_GET['s'];
				if ($search == null) {
					header('Location: '.$_SERVER['HTTP_REFERER']);
				}
				@$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
				$dbError = mysqli_connect_error();
				if ($dbError){
					echo "Error: Could not connect to database. Please try again later. ".$dbError;
				} else {
					#check if searched data does exists
					$query = "
							SELECT * 
							FROM product 
							INNER JOIN product_category ON product.id = product_category.product_id 
							WHERE product_category.category LIKE ? OR product.name LIKE ?
							LIMIT 10;
						";
					$stmt = $db->prepare($query);
					$search = "%".$search."%";
					$stmt->bind_param('ss', $search, $search);
					$stmt->execute();
					$result = $stmt->get_result();
					$resultCount = $result->num_rows;
					if ($resultCount == 0) {
						echo "<h5>No result found</h5>";
					} else {
						echo "
							<table class=\"table\">
						";
						for ($ctr = 0; $ctr < $resultCount; $ctr++) { 
							$row = $result -> fetch_assoc();
							echo "
								<tr class=\"row\">
									<td class=\"col-2\">
										<a href=\"product.php?p=".$row['id']."\">
											<img class=\"img-thumbnail\" src=\"".$row['image']."\">
											</a>
									</td>
									<td class=\"col\">
										<a class=\"text-dark card-link\" href=\"product.php?p=".$row['id']."\">
											<br><br>
											<h6>".$row['name']."</h6>
											<p>₱".$row['price']."</p>
										</a>
									</td>
								</tr>
							";
						}
						echo "</table>";
					}
				}
			?>
		</div>
	</div>
</div>
<?php 
	require_once 'template/footing.php';
?>