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
		
		$user = $_GET['user'];

		echo '<div id="container">';
		echo "<center><h2>Strona użytkownika</h2></center>";
		if($connection->connect_errno != 0) {
			echo "Error: ".$connection->connect_errno; 
		} else {
			$result = mysqli_query($connection,"SELECT * FROM users WHERE user='$user'");
			while($row = mysqli_fetch_array($result)) {
				$user = $row['user'];
				$vcount = $row['vcount'];
				$pcount = $row['pcount'];
				$email = $row['email'];
				
				//echo '<div class="box">';
				echo 'Użyszkodnik: <a href="user?user='.$user.'"><b>'.$user.'</b></a>';
				echo '<br />Liczba postów wulgarnych: '.$vcount;
				echo '<br />Liczba postów miłych: '.$pcount;
				echo '<br />Email: '.$email;
				//echo '</div>';
			}
			if($result->num_rows > 0) {
				
			} else {
				echo 'Wyglada na to że nic tu niema :) ';
			}
			mysqli_close($connection);
		}
		
		echo '</div>';
		
		
	?>
	
</body>
</html>