<?php
	session_start();
	if(!isset($_SESSION['logged']) || ($_SESSION['logged'] = false) ) {
		header('Location: home');
		exit();
	} 
	require_once "connect.php";
	if($_POST['sendarea'] != NULL) {
		if($connection->connect_errno != 0) {
			echo "Error:".$connection->connect_errno;
		} else {
			if($_POST['sendarea'] != NULL) {
				$sendarea = $_POST['sendarea'];
				$userid = $_SESSION['userid'];
				$words = file_get_contents('words.txt');
				$words = str_replace("
","[a-z]*|[a-z]*",$words);
				$sendareax = eregi_replace($words,"[CENZURA]",$sendarea);
				
				$date = date('d-m-Y \<H:i:s\>');
				
				if($sendarea == $sendareax) {
					$sql = "INSERT INTO topics VALUES (NULL,'$userid','$sendareax','$date')";
					mysqli_query($connection,$sql);
					
					if($connection->connect_errno != 0) {
						echo "Error: ".$connection->connect_errno; 
					} else {
						$result = mysqli_query($connection,"SELECT pcount FROM users WHERE userid='$userid'");
						$row = mysqli_fetch_array($result);
						$pcount = $row['pcount'];
						$pcount++;
						mysqli_query($connection,"UPDATE users SET pcount='$pcount' WHERE userid='$userid'");
					}
					
					
				} else {
					$sql = "INSERT INTO topics VALUES (NULL,'$userid','$sendareax','$date')";
					mysqli_query($connection,$sql);

					if($connection->connect_errno != 0) {
						echo "Error: ".$connection->connect_errno; 
					} else {
						$result = mysqli_query($connection,"SELECT vcount FROM users WHERE userid='$userid'");
						$row = mysqli_fetch_array($result);
						$vcount = $row['vcount'];
						
						$vcount++;
						
						mysqli_query($connection,"UPDATE users SET vcount='$vcount' WHERE userid='$userid'");
					};
				}
				header('Location:forum');
				mysqli_close($connection);
			}
		}
	} else header('Location:forum?addtopic');
	
	
?>
