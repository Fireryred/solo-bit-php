<?php
	require_once 'reference/properties.php';
	require_once 'services/log-service.php';
	session_start();
	if (@$_SESSION['username'] == null) {
		header('Location: index.php');
	}
	$back = $_SERVER['HTTP_REFERER'];
	if ($back == null) {
		$back = 'index.php';
	}
	@$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$dbError = mysqli_connect_error();
	if ($dbError){
		echo "Error: Could not connect to database. Please try again later. ".$dbError;
	} else {
		#check if order id is already generated
		if (!isset($_COOKIE['order_id'])) {
			#get current user's id and binding it to order id
			$username = $_SESSION['username'];
			$query = "
				SELECT * FROM user_details
				WHERE username=?;
			";
			$stmt = $db->prepare($query);
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			if ($row) {
				$query = "
					INSERT INTO order_number(user_id) VALUES (?); 
				";
				$stmt = $db->prepare($query);
				$stmt->bind_param('i', $row['id']);
				$stmt->execute();
				setcookie('order_id', $db->insert_id, time() + 3600);
				$order_id = $db->insert_id;
			}
		} else {
			$order_id = $_COOKIE['order_id'];
			setcookie('order_id', $order_id, time() + 3600);
		}
		$product_id = $_POST['id'];
		$qty = $_POST['qty'];
		#check if product exists in the order id
		$query = "
			SELECT * FROM order_details WHERE product_id=? AND order_id=?;
		";
		$stmt = $db->prepare($query);
		$stmt->bind_param('ii', $product_id, $order_id);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->fetch_assoc()) {
			header('Location: '.$back);
		} else {
			#store to db
			$query = "
				INSERT INTO order_details(order_id, product_id, qty) VALUES (?,?,?);
			";
			$stmt = $db->prepare($query);
			$stmt->bind_param('iii', $order_id, $product_id, $qty);
			$stmt->execute();
			logMessage("Add to cart by: ".$_SESSION['username']."Order ID: ".$order_id);
			header('Location: '.$back);
		}
	}
?>