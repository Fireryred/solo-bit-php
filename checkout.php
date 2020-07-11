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
?>
<div class="container-fluid">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col">
					<div class="row">
						<div class="col-2"></div>
						<div class="col">
							<form class="form" method="post" action="checkout-process.php">
								<h4>Payment Method</h4>
								<div class="form-group">
									<div class="form-check">
										<input type="radio" name="payment" id="payment1" value="onDelivery" required>
										<label class="form-check-label" for="payment1">Cash on Delivery</label>
									</div>
									<div class="form-check">
										<input type="radio" name="payment" id="payment2" value="creditCard">
										<label class="form-check-label" for="payment2">Credit Card</label>
									</div>
								</div>
								<div class="form-group">
									<label for="creditCardNumber">Credit Card Number</label>
									<?php
										if (@in_array('month', json_decode(@$_GET['e']))) {
											echo "<input class=\"form-control is-invalid\" type=\"text\" name=\"creditCardNumber\" id=\"creditCardNumber\" placeholder=\"1313-2424-3535-4646\">";
										} else {
											echo "<input class=\"form-control\" type=\"text\" name=\"creditCardNumber\" id=\"creditCardNumber\" placeholder=\"1313-2424-3535-4646\">";
										}
									?>
								</div>
								<div class="form-group">
									<label for="expirationDate">Expiration Date</label>
									<div class="row">
										<div class="col">
											<?php
												if (@in_array('month', json_decode(@$_GET['e']))) {
													echo "<select class=\"form-control border-danger\" name=\"month\">";
												} else {
													echo "<select class=\"form-control\" name=\"month\">";
												}
											?>
												<option value="">Month</option>
												<option value="January">January</option>
												<option value="Febuary">Febuary</option>
												<option value="March">March</option>
												<option value="April">April</option>
												<option value="May">May</option>
												<option value="June">June</option>
												<option value="July">July</option>
												<option value="August">August</option>
												<option value="September">September</option>
												<option value="October">October</option>
												<option value="November">November</option>
												<option value="December">December</option>
											</select>
										</div>
										<div class="col">
												<?php
												if (@in_array('year', json_decode(@$_GET['e']))) {
													echo "<select class=\"form-control border-danger\" name=\"year\">";
												} else {
													echo "<select class=\"form-control\" name=\"year\">";
												}
												echo "<option value=\"\">Year</option>";
												$year = intval(date("Y"));
												for ($i=0; $i < 3; $i++) { 
													$year += 1;
													echo "<option value=\"$year\">".$year."</option>";
												}
											?>
											</select>
										</div>
										<label for="cvv">CVV</label>
										<div class="col-3">
										<?php
											if (@in_array('cvv', json_decode(@$_GET['e']))) {
												echo "
												<input type=\"text\" name=\"cvv\" id=\"cvv\" class=\"form-control is-invalid\">
												";
											} else {
												echo "<input type=\"text\" name=\"cvv\" id=\"cvv\" class=\"form-control\">";
											}
											?>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="address">Address</label>
									<?php
									@$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
									$dbError = mysqli_connect_error();
									if ($dbError){
										echo "Error: Could not connect to database. Please try again later. ".$dbError;
									} else {
										$username = $_SESSION['username'];
										$query = "
											SELECT id, username FROM user_details WHERE username=?;
										";
										$stmt = $db->prepare($query);
										$stmt->bind_param('s', $username);
										$stmt->execute();
										$result = $stmt->get_result();
										$row = $result->fetch_assoc();
										if ($row) {
											$user_id = $row['id'];
										}
										$query = "
											SELECT * FROM user_address WHERE user_id=?;
										";
										$stmt = $db->prepare($query);
										$stmt->bind_param('s', $user_id);
										$stmt->execute();
										$result = $stmt->get_result();
										$row = $result->fetch_assoc();
										if ($row) {
											echo "<input type=\"text\" name=\"address\" id=\"address\" class=\"form-control\" placeholder=\"Address\" value=\"".$row['address']."\" required>";
										} else {
											echo "<input type=\"text\" name=\"address\" id=\"address\" class=\"form-control\" placeholder=\"Address\" required>";
										}
									}
									?>
								</div>
								<div class="form-group">
									<input type="submit" class="btn btn-primary" value="Place Order">
								</div>
							</form>
						</div>
						<div class="col-2"></div>
					</div>
				</div>
				<div class="col">
					<br>
					<br>
					<h4 class="d-inline">Cart Summary</h4>
					<a href="view-cart.php" class="d-inline card-link">edit</a>
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
											Sub Total:<h6> $sum</h6>
										</td>
									</tr>
								</tbody>
							</table>
							";
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	require_once 'template/footing.php';
?>