<?php
	session_start();
	if(!isset($_POST['login']) && !isset($_POST['password'])) {
		header('Location:home');
		exit();
	}
	require_once "connect.php";
	// mamy tu $connection
	
	if($connection->connect_errno != 0) {
		echo "Error: ".$connection->connect_errno;
	} else {
		$login = $_POST['login'];
		$pwd = $_POST['password'];
		
		// zamiana niebezpiecznych znakow na encje 
		$login = htmlentities($login,ENT_QUOTES, "UTF-8");
		$pwd = htmlentities($pwd,ENT_QUOTES, "UTF-8");
		
		$sql = "SELECT * FROM users WHERE user='$login' AND pwd='$pwd'";
		
		$result = $connection->query($sql);
		
		if($result) {
			if($result->num_rows > 0) {
				
				echo "ilość wierszy znalezionych: $result->num_rows";
				$row = $result->fetch_assoc();
				if($row['banned'] == 1) {
					$_SESSION['loginerror'] = '<span style="color:red">Masz bana!</span>';
					header('Location: home');
				} else {
					$_SESSION['logged'] = true;
					$_SESSION['userid'] = $row['userid'];
					$_SESSION['user'] = $row['user'];
					$_SESSION['pwd'] = $row['pwd'];
					$_SESSION['banned'] = $row['banned'];
					header('Location: forum');
					$result->close();
				}
				
			} else {
				$_SESSION['loginerror'] = '<span style="color:red">Nieprawidłowe dane!</span>';
				header('Location: home');
			}
		} else echo "cos nie tak z result";
		$connection->close();
	}
	

?>