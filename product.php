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
				@$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
				$dbError = mysqli_connect_error();
				if ($dbError){
					echo "Error: Could not connect to database. Please try again later. ".$dbError;
				} else {
					#getting data of the product
					$query = "
						SELECT * FROM product WHERE id=?;
					";
					$stmt = $db->prepare($query);
					$stmt->bind_param('s', $_GET['p']);
					$stmt->execute();
					$result = $stmt->get_result();
					$product = $result->fetch_assoc();
					if ($product) {
						if (strlen($product['price']) > 3) {
							$price = substr_replace($product['price'], ',', strlen($product['price'])-3, 0);
						} else {
							$price = $product['price'];
						}
						$order_id = @$_COOKIE['order_id'];
						$query = "
							SELECT * FROM order_details WHERE product_id=? AND order_id=?;
						";
						$stmt = $db->prepare($query);
						$stmt->bind_param('ii', $_GET['p'], $order_id);
						$stmt->execute();
						$result = $stmt->get_result();
						if ($result->fetch_assoc()) {
							$hasProduct = 'disabled';
						}
						echo "
							<table class=\"table\">
								<tr class=\"row\">
									<td class=\"col-5\"><img class=\"img-thumbnail\" src=".$product['image']."></td>
									<td class=\"col\">
										<h4>".$product['name']."</h4>
										<p>₱".$price."</p>
										<form class=\"form\" action=\"add-to-cart-process.php\" method=\"post\">
											<div class=\"form-group\">
												<input type=\"number\" name=\"id\" value=".$_GET['p']." class=\"d-none\">
												<label for=\"qty\">Quantity:</label>
												<div class=\"input-group col-3 p-0\">
													<input type=\"number\" name=\"qty\" id=\"qty\" min=\"1\" value=\"1\" class=\"form-control\">
													<div class=\"input-group-append\">
														<input type=\"submit\" class=\"btn btn-primary\" value=\"Add to cart\" ".@$hasProduct.(@$_SESSION['username'] == null ?'disabled':'').">
													</div>
													".(@$_SESSION['username'] == null ?'<p>Login to use add to cart</p>':'').
													(@$hasProduct !== null ? '<p>Product is already in the cart</p>':'')."
												</div>
											</div>
										</form>
									</td>
								</tr>
							</table>
						";
					}
				}
			?>
		</div>
	</div>
</div>
<?php 
	require_once 'template/footing.php';
?>