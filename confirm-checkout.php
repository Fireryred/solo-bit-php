<?php 
	session_start();
	require_once 'reference/properties.php';
	require_once 'template/heading.php';
	if (@$_SESSION['username'] != null) {
		require_once 'template/navbar-user.php';
	} else {
		header('Location: index.php');
	}
	$order_id = @$_COOKIE['order_id'];
	if ($order_id == null) {
		header('Location: index.php');
	}
	if ($_SERVER['HTTPS'] != 'on') {
		header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		exit;
	}
?>
<div class="container-fluid">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-3"></div>
				<div class="col">
					<div class="d-flex justify-content-center">
						<p>Your Order Number: <?=$order_id?></p>
					</div>
					<div class="d-flex justify-content-center">
						<p>Your Type of Payment: 
							<?php 
								$username = $_SESSION['username'];
								@$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
								$dbError = mysqli_connect_error();
								if ($dbError){
									echo "Error: Could not connect to database. Please try again later. ".$dbError;
								} else {
									$query = "
										SELECT payment, address 
										FROM user_address
										INNER JOIN user_details ON user_address.user_id = user_details.id
										WHERE user_details.username=?;
									";
									$stmt = $db->prepare($query);
									$stmt->bind_param('s', $username);
									$stmt->execute();
									$result = $stmt->get_result();
									$row = $result->fetch_assoc();
									if ($row) {
										if ($row['payment'] == 'onDelivery') {
											echo "Cash on Delivery";
										} else {
											echo "Credit/Debit Card";
										}
									}
								}
							?>
						</p>
					</div>
					<div class="d-flex justify-content-center">
						<p>Your Shipping Address: <?=$row['address']?></p>
					</div>
					<?php 
						
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
										<th class=\"col d-flex justify-content-center\">Qunatity</th>
										<th class=\"col-6 d-flex justify-content-center\">Product</th>
										<th class=\"col d-flex justify-content-center\">Total</th>
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
									echo "
										<tr class=\"row\">
											<td class=\"col d-flex align-items-center justify-content-center\">
												".$row['qty']."
											</td>
											<td class=\"col\">
												<img class=\"img-thumbnail\" src=\"".$row['image']."\">
											</td>
											
											<td class=\"col d-flex align-items-center justify-content-center\">
												<h6>".$row['name']."</h6>
											</td>
											<td class=\"col d-flex align-items-center justify-content-center\">
												$product
											</td>
										</tr>
									";
								}
							}
							echo "
									<tr class=\"row\">
										<td class=\"col d-flex justify-content-end\">
											<p>Total:<h6>$sum</h6></p>
										</td>
									</tr>
								</tbody>
							</table>
							";
						}
					?>
					<a href="confirm-checkout-process.php" class="btn btn-primary">Confirm Checkout</a>
					<a href="checkout.php" class="btn btn-primary">Cancel</a>	
				</div>
				<div class="col-3"></div>
			</div>
		</div>
	</div>
</div>