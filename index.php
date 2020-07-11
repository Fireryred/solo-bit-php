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
				$category = array('laptop', 'smartphone');
				@$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
				$dbError = mysqli_connect_error();
				if ($dbError){
					echo "Error: Could not connect to database. Please try again later. ".$dbError;
				} else {
					#getting the products
					foreach ($category as $type) {
						$query = "
							SELECT * 
							FROM product 
							INNER JOIN product_category ON product.id = product_category.product_id 
							WHERE product_category.category=?
							LIMIT 5;
						";
						$stmt = $db->prepare($query);
						$stmt->bind_param('s', $type);
						$stmt->execute();
						$result = $stmt->get_result();
						$resultCount = $result->num_rows;
						if ($resultCount != 0) {
							echo "
								<table class=\"table\">
									<thead>
										<tr class=\"row\">
											<th class=\"col\">".ucwords($type)."</th>
										</tr>
									</thead>
									<tbody>
										<tr class=\"row\">
							";
							for ($ctr=0; $ctr < $resultCount; $ctr++) { 
								$row = $result->fetch_assoc();
								if (strlen($row['price']) > 3) {
									$price = substr_replace($row['price'], ',', strlen($row['price'])-3, 0);
								} else {
									$price = $row['price'];
								}
								
								echo "
									<td class=\"col\">
										<a href=\"product.php?p=".$row['id']."\">
											<p>".$row['name']."</p>
											<img class=\"img-thumbnail\" src=".$row['image'].">
											<p>₱".$price."</p>
										</a>
									</td>
								";
							}
							echo "
										</tr>
									</tbody>
								</table>
							";
						}
					}
				}
			?>
		</div>
	</div>
</div>
<?php 
	require_once 'template/footing.php';
?>