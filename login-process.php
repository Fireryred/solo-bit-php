<?php
	require_once 'reference/properties.php';
	require_once 'services/log-service.php';
	session_start();
	$username = $_POST['username'];
	$password = $_POST['password'];
	try {
		$error = array();
		@$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
		$dbError = mysqli_connect_error();
		if ($dbError){
			echo "Error: Could not connect to database. Please try again later. ".$dbError;
		} else {
			#check if username is registered
			$query = "
				SELECT * FROM user_details WHERE username=?;
			";
			$stmt = $db->prepare($query);
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$result = $stmt->get_result();
			$resultCount = $result->num_rows;
			if ($resultCount == 0) {
				array_push($error, "Username not exists");
			}
			#username and password check
			$query = "
				SELECT * FROM user_details
				WHERE username=? AND password=?;
			";
			$pass = hash('sha512', $password);
			$stmt = $db->prepare($query);
			$stmt->bind_param('ss', $username, $pass);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->fetch_assoc()) {
				logMessage("Successfull Login: ".$username);
				$_SESSION['username'] = $username;
				header('Location: index.php');
			} else {
				array_push($error, "Password wrong");
			}
			if ($error != null) {
				$_SESSION['error'] = $error;
				throw new Exception("", 0);
			}
		}
	} catch (Exception $e) {
		header('Location: login.php');
	}	
?>