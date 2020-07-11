<?php 
	require_once 'reference/properties.php';
	require_once 'services/log-service.php';
	session_start();
	if (@$_SESSION['username'] == null) {
		header('Location: index.php');
	}
	logMessage("Order has been confirm by: ".$_SESSION['username']);
	setcookie('order_id', $order_id, time() - 3600);
	header('Location: order-success.php');
?>