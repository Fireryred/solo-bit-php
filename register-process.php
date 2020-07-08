<?php
	require_once 'reference/properties.php';
	require_once 'services/log-service.php';
	session_start();
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$confirmPassword = $_POST['confirmPassword'];
	if (isset($username) || isset($password) || isset($email) || isset($firstName) || isset($lastName) || isset($confirmPassword)) {
		try {
			$error = array();
			@$db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
			$dbError = mysqli_connect_error();
			if ($dbError){
				echo "Error: Could not connect to database. Please try again later. ".$dbError;
			} else {
				#check if username exist
				$query = "
					SELECT * FROM user_details
					WHERE username=?;
				";
				$stmt = $db->prepare($query);
				$stmt->bind_param('s', $username);
				$stmt->execute();
				$result = $stmt->get_result();

				#input validation
				if ($result->fetch_assoc()) {
					array_push($error, "Username taken");
				}
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					array_push($error, "Email invalid");
				}
				if ($password != $confirmPassword) {
					array_push($error, "Password not same", " " , $password, "=", $confirmPassword);
				}
				if (!preg_match("#[0-9]+#", $password) || !preg_match("#[A-Z]+#", $password) || !preg_match("#[a-z]+#", $password)) {
					array_push($error, "Password invalid");
				}
				if (strpos($password, $username)) {
					array_push($error, "Username Password same");
				}


				$_SESSION['error'] = $error;
				if ($error != null) {
					throw new Exception('',0);
				} else {
					if (isset($_POST['middleName'])) {
						$fullName = $firstName." ".$_POST['middleName']." ".$lastName;
					} else {
						$fullName = $firstName." ".$lastName;
					}
					$query = "
						INSERT INTO user_details (username, password, email, full_name) VALUES (?,?,?,?);
					";
					$stmt = $db->prepare($query);
					$stmt->bind_param('ssss', $username, hash('sha512', $password), $email, $fullName);
					$stmt->execute();
					$stmt->close();
					logMessage('Successful register of: '.$username);
					header('Location: login.php');
				}

			}
		} catch (Exception $e) {
			header('Location: register.php');
		}
	} else {
		header('Location: register.php');
	}
?>