<?php
	session_start();
	if(!isset($_SESSION['logged']) || ($_SESSION['logged'] = false) ) {
		header('Location: home');
		exit();
	}
	
	require_once "connect.php";
	if(isset($_POST['sendarea']) && $_POST['sendarea'] != NULL) {
		if($connection->connect_errno != 0) {
			echo "Error:".$connection->connect_errno;
		} else {
			$userid = $_SESSION['userid'];
			$sendarea = $_POST['sendarea'];
			$id = $_GET['id'];
			$words = file_get_contents('words.txt');
			$words = str_replace("
","[a-z]*|[a-z]*",$words);
			$sendareax = eregi_replace($words,"[CENZURA]",$sendarea);
			
			$date = date('d-m-Y \<H:i:s\>');
			
			
			if($sendarea == $sendareax) {
				$sql = "INSERT INTO posts VALUES (NULL,'$userid','$id','$sendareax', '$date')";
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
				$sql = "INSERT INTO posts VALUES (NULL,'$userid','$id','$sendareax', '$date')";
				mysqli_query($connection,$sql);
				if($connection->connect_errno != 0) {
					echo "Error: ".$connection->connect_errno; 
				} else {
					$result = mysqli_query($connection,"SELECT vcount,pcount FROM users WHERE userid='$userid'");
					$row = mysqli_fetch_array($result);
					$vcount = $row['vcount'];
					
					$vcount++;
				
					mysqli_query($connection,"UPDATE users SET vcount='$vcount' WHERE userid='$userid'");
				}

				
			}	
			//header('Location:posts?id='.$id);
			//mysqli_close($connection);
			
		}
		//$_SESSION['loginerror'] = '<span style="color:red">Nie klnij mały kurwiu.</span>';
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Mini Forum!</title>
	
	<meta name="description" content="Opis w Google" />
	<meta name="keywords" content="słowa, kluczowe, wypisane, po, przecinku" />
	
	<link rel="stylesheet" href="style.css" />
</head>

<body onload="document.getElementById('send').focus()">
	<?php
		require_once "navi.php";
		navi();
	?>
	<?php 
		//require_once "connect.php";
		//echo '<div id="container">';
		
		
		$id = $_GET['id'];
	
	if($connection->connect_errno != 0) {
			echo "Error: ".$connection->connect_errno; 
		} else {
			
			$result3 = mysqli_query($connection,"SELECT topic FROM topics WHERE topicid=$id");
			$topicx = mysqli_fetch_array($result3);
			$topic = $topicx['topic'];
			echo "<center><h2>".$topic."</h2></center>";
			$result = mysqli_query($connection,"SELECT * FROM posts WHERE topicid=$id");
			
			while($row = mysqli_fetch_array($result)) {
				$userid = $row['userid'];
				$post = $row['post'];
				$date = $row['date'];
				$result2 = mysqli_query($connection,"SELECT user FROM users WHERE userid='$userid'");
				$userx = mysqli_fetch_array($result2);
				$user = $userx['user'];
				
				echo '<div class="box" style="margin:0 auto">';
				echo '<a href="user?user='.$user.'">'.$user.'</a>';
				echo '<br />'.$post.'<br />';
				echo '<i style="color:grey;font-size:12.5px;">'.$date.'</i><br />';
				echo '</div>';
				
			}
			if($result->num_rows > 0) {
				
			} else {
				echo 'Wyglada na to że nic tu niema :) ';
			}
			mysqli_close($connection);
			
		}
	
		
		//echo '</div>'; //koniec container
		
		
	?>
	<br />
	<br />
	<center>
		<div class="box">
		<form method="post">
			
			<input id="send" class="podkrec5" type="text" name="sendarea" placeholder="Napisz post"  style="margin-bottom:6px;"/>
			<br />
			<input type="submit" class="button" value="Postuj" />
		</form>
		<br />
		<a href="home">Wróć</a>
		</div>
		
		<?php 
		if(isset($_SESSION['loginerror']))	{
			echo $_SESSION['loginerror'];
			unset($_SESSION['loginerror']);
		};
		?>
	</center>
	
</body>
</html>