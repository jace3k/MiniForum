<?php
	echo 'czy to dziala';
?>
/*
session_start();
	if(!isset($_SESSION['logged']) || ($_SESSION['logged'] = false) ) {
		header('Location: home');
		exit();
	} 
	require_once "connect.php";
	if($_POST['sendarea2'] != NULL) {
		if($connection->connect_errno != 0) {
			echo "Error:".$connection->connect_errno;
		} else {
				$userid = $_SESSION['userid'];
				$sendarea = $_POST['sendarea2'];
				$id = $_GET['id'];
				$sql = "INSERT INTO posts VALUES (NULL,'$userid','$id','$sendarea')";
				mysqli_query($connection,$sql);
				header('Location:posts?id=$id');				
				mysqli_close($connection);
			
		}
	} else header('Location:posts?id='.$id.'');
	
	*/