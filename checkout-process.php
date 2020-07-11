<?php 
	require_once 'reference/properties.php';
	require_once 'services/log-service.php';
	session_start();
	if (@$_SESSION['username'] == null) {
		header('Location: index.php');
	}
	#welp this is useless now, it's working but now it's not
	//this suppossedly if the user choose credit card, it then checks if an input is filled
	// $type = $_POST['payment'];
	// if ($type == 'creditCard') {
	// 	$cNumber = $_POST['creditCardNumber'];
	// 	$month = $_POST['month'];
	// 	$year = $_POST['year'];
	// 	$cvv = $_POST['cvv'];
	// 	$error = array();
	// 	if ($cNumber == null) {
	// 		array_push($error, 'creditcard');
	// 	}
	// 	if ($month == null) {
	// 		array_push($error, 'month');
	// 	}
	// 	if ($year == null) {
	// 		array_push($error, 'year');
	// 	}
	// 	if ($cvv == null) {
	// 		array_push($error, 'cvv');
	// 	}
	// 	$code = json_encode($error);
	// 	if ($error != null) {
	// 		header('Location: checkout.php?e='.$code);
	// 	}
	@$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$dbError = mysqli_connect_error();
	if ($dbError){
		echo "Error: Could not connect to database. Please try again later. ".$dbError;
	} else {
		#getting id of current user
		$address = $_POST['address'];
		$username = $_SESSION['username'];
		$type = $_POST['payment'];
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
		#check if user has address
		$query = "
			SELECT * FROM user_address WHERE user_id=?;
		";

		$stmt = $db->prepare($query);
		$stmt->bind_param('s', $user_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		if ($row) {
			#updating it to user_address
			$query = "
				UPDATE user_address SET address=?, payment=? WHERE user_id=?;
			";
			$stmt  = $db->prepare($query);
			$stmt->bind_param('ssi', $address, $type, $user_id);
			$stmt->execute();
			header('Location: confirm-checkout.php');
		} else {
			#adding it to user_address
			$query = "
				INSERT INTO user_address(user_id, address, payment) VALUES (?,?);
			";
			$stmt  = $db->prepare($query);
			$stmt->bind_param('is', $user_id, $address, $type);
			$stmt->execute();
			header('Location: confirm-checkout.php');
		}
	}
?>