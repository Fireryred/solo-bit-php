<?php 
	require_once 'reference/properties.php';
	require_once 'services/log-service.php';
	session_start();
	if (@$_SESSION['username'] == null) {
		header('Location: index.php');
	}
	@$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$dbError = mysqli_connect_error();
	if ($dbError){
		echo "Error: Could not connect to database. Please try again later. ".$dbError;
	} else {
		$order_id = $_COOKIE['order_id'];
		$product_id = $_POST['id'];
		$query = "
			DELETE FROM order_details WHERE product_id=? AND order_id=?;
		";
		$stmt = $db->prepare($query);
		$stmt->bind_param('ii', $product_id, $order_id);
		$stmt->execute();
		logMessage("Delete product id ".$product_id." from cart by user: ".$_SESSION['username']);
		setcookie('order_id', $order_id, time() + 3600);
		header('Location: view-cart.php');
	}
?>