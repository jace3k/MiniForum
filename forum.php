<?php
	session_start();
	if(!isset($_SESSION['logged']) || ($_SESSION['logged'] = false) ) {
		header('Location: home');
		exit();
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

<body>
	<?php
		require_once "navi.php";
		navi();
	?>
	<?php 
		require_once "connect.php";
		

		echo '<div id="container">';
		echo "<center><h2>Tematy</h2></center>";
		if($connection->connect_errno != 0) {
			echo "Error: ".$connection->connect_errno; 
		} else {
			$result = mysqli_query($connection,"SELECT * FROM topics");
			while($row = mysqli_fetch_array($result)) {
				$userid = $row['userid'];
				$topicid = $row['topicid'];
				$date = $row['date'];
				$result2 = mysqli_query($connection,"SELECT user FROM users WHERE userid='$userid'");
				$userx = mysqli_fetch_array($result2);
				$user = $userx['user'];
				
				echo '<div class="msg">';
				echo '<div class="title">';
				echo '<a href="user?user='.$user.'"><b>'.$user.'</b></a>';
				
				if(($_SESSION['userid'] == $userid) || ($_SESSION['user'] == "alex"))
				echo "<br /><br /><a href=del?id=".$topicid.">[X]</a>";
				echo '</div>';
				echo "<a href=posts?id=".$topicid."><div class='post'>".$row['topic']."</div></a>";
				echo '<br />';
				echo '<i style="color:grey;font-size:12.5px;">'.$date.'</i><br />';
				echo '</div>';
			}
			if($result->num_rows > 0) {
				
			} else {
				echo 'Wyglada na to że nic tu niema :) ';
			}
			mysqli_close($connection);
		}
		
		echo '</div>';
		
		
	?>
	<br />
	<br />
	<center>
	<div class="box" >
		<h2>Nowy temat</h2>
		<form action="add" method="post">
		<input class="podkrec5" type="text" name="sendarea" placeholder="Nazwa tematu" style="margin-bottom:6px;"/>
		<br />
		<input type="submit" name="send" value="Utwórz" class="button" />
		</form>
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