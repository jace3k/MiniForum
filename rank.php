<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Mini Forum!</title>
	
	<meta name="description" content="Opis w Google" />
	<meta name="keywords" content="słowa, kluczowe, wypisane, po, przecinku" />
	
	<link rel="stylesheet" href="style.css" />
	<style>
		td,th {
			padding:20px;
			border:1px solid black;
	
		}
	</style>
</head>

<body>
	<?php
		session_start();
		require_once "navi.php";
		navi();
	?>
	<?php 
		require_once "connect.php";
		

		echo '<div id="container"><center>';
		echo "<center><h2>Ranking userów</h2></center>";
		if($connection->connect_errno != 0) {
			echo "Error: ".$connection->connect_errno; 
		} else {
			$result = mysqli_query($connection,"SELECT user,vcount,pcount FROM users ORDER BY vcount DESC, pcount DESC");
			$count = 1;
			echo '<table><tr><th>L.p</th><th>User</th><th>Wulgarne posty</th><th>Miłe posty</th></tr>';
			while($row = mysqli_fetch_array($result)) {
				$user = $row['user'];
				$vcount = $row['vcount'];
				$pcount = $row['pcount'];
				echo '<tr><td>'.$count.'</td><td><a href="user?user='.$user.'">'.$user.'</a></td><td>'.$vcount.'</td><td>'.$pcount.'</td></tr>';
				$count++;
			}
			echo '</table>';
			
			if($result->num_rows > 0) {
				
			} else {
				echo 'Wyglada na to że nic tu niema :) ';
			}
			mysqli_close($connection);
		}
		echo '</center></div>';
		
	?>
	<br />
	<br />
	
	
</body>
</html>