<?php
	session_start();
	require_once "connect.php";
	if(!isset($_SESSION['logged']) || ($_SESSION['logged'] = false) ) {
		header('Location: home');
		exit();
	}
	if(isset($_GET['id'])) {	
		$id = $_GET['id'];
		$sql = "DELETE FROM topics WHERE topicid='$id'";
		mysqli_query($connection,$sql);
			
		$sql = "DELETE FROM posts WHERE topicid='$id'";
		mysqli_query($connection,$sql);
	}
	mysqli_close($connection);
	
	header('Location: forum');
	
?>
