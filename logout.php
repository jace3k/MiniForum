<?php
	session_start();
	$_SESSION['logged'] = false;
	session_unset();
	header('Location:home');
?>