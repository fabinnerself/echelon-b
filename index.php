<?php
	 session_start();

	$_SESSION['id_usuario']="";
	unset($_SESSION['id_usuario']);
	session_unset(); 
	session_destroy();
	header("Location: login1.php");
	exit;
?>