<?php 
	session_start();
	require_once 'reference/properties.php';
	require_once 'template/heading.php';
	if (@$_SESSION['username'] != null) {
		require_once 'template/navbar-user.php';
	} else {
		header('Location: '.$_SERVER['HTTP_REFERER']);
	}
?>
<div class="container-fluid">
	<div class="card">
		<div class="card-body">
			<h1>View Cart</h1>
			<?php 
				$order_id = @$_COOKIE['order_id'];
				if ($order_id == null) {
					echo "<p>No product has been added to the cart</p>";
				} else {
					@$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
					$dbError = mysqli_connect_error();
					if ($dbError){
						echo "Error: Could not connect to database. Please try again later. ".$dbError;
					} else {
						#getting data
						$query = "
							SELECT product_id, product.name, product.image, product.price, qty, order_number.user_id
							FROM order_details 
							INNER JOIN order_number ON order_number.id = order_details.order_id 
							INNER JOIN product ON product.id = order_details.product_id 
							WHERE order_id=?;
						";
						$stmt = $db->prepare($query);
						$stmt->bind_param('i', $order_id);
						$stmt->execute();
						$result = $stmt->get_result();
						$resultCount = $result->num_rows;
						echo "
						<table class=\"table\">
							<thead>
								<tr class=\"row\">
									<th class=\"col\"></th>
									<th class=\"col d-flex justify-content-center\">Product</th>
									<th class=\"col d-flex justify-content-center\">Price</th>
									<th class=\"col d-flex justify-content-center\">Qunatity</th>
									<th class=\"col d-flex justify-content-center\">Total</th>
									<th class=\"col\"></th>
								</tr>
							</thead>
							<tbody>
								
						";
						#displaying data
						if ($resultCount != 0) {
							for ($ctr=0; $ctr < $resultCount; $ctr++) { 
								$row = $result->fetch_assoc();
								$product = $row['price'] * $row['qty'];
								@$sum += $product;
								if (strlen($row['price']) > 3) {
									$price = substr_replace($row['price'], ',', strlen($row['price'])-3, 0);
								} else {
									$price = $row['price'];
								}
								echo "
									<tr class=\"row\">
										<td class=\"col\">
											<img class=\"img-thumbnail\" src=\"".$row['image']."\">
										</td>
										<td class=\"col d-flex align-items-center justify-content-center\">
											<h6>".$row['name']."</h6>
										</td>
										<td class=\"col d-flex align-items-center justify-content-center\">".$price."</td>
										<td class=\"col d-flex align-items-center justify-content-center\">
											<form action=\"view-cart-update.php\" method=\"post\">
												<input type=\"number\" class=\"d-none\"name=\"id\" value=\"".$row['product_id']."\">
												<input class=\"form-control\" type=\"number\" min=\"1\" value=\"".$row['qty']."\" name=\"qty\">
												<input type=\"submit\" class=\"btn btn-primary\" value=\"Update\">
											</form>
										</td>
										<td class=\"col d-flex align-items-center justify-content-center\">
											<form action=\"view-cart-delete\" method=\"post\">
												$product
											</form>
										</td>
										<td class=\"col d-flex align-items-center justify-content-center\">
											<form action=\"view-cart-delete.php\" method=\"post\">
												<input type=\"number\" class=\"d-none\"name=\"id\" value=\"".$row['product_id']."\">
												<input type=\"submit\" class=\"btn btn-primary\" value=\"Remove\">
											</form>
										</td>
									</tr>
								";
							}
							echo "
								</tbody>
							</table>
							<div class=\"row\">
								<div class=\"col-6\"></div>
								<div class=\"col\">
									<h2>Cart Total</h2>
									<table class=\"table\">
										<tr class=\"row\">
											<td class=\"col-3\"><h6>Subtotal</h6></th>
											<td class=\"col-3\">$sum</td>
										</tr>
										<tr class=\"row\">
											<td class=\"col-3\"><h6>Total</h6></th>
											<td class=\"col-3\">$sum</td>
										</tr>
									</table>
									<form action=\"checkout.php\" method=\"post\">
										<input type=\"submit\" class=\"btn btn-primary\" value=\"Proceed to Checkout\">
									</form>
								</div>
							</div>
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