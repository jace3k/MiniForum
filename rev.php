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
<center>
	<?php
		session_start();
		require_once "navi.php";
		navi();
		
		if((isset($_POST['review'])) && ($_POST['review'] != NULL)) 
		{
			require_once "connect.php";
			$rev = $_POST['review'];
			$sql = "INSERT INTO reviews VALUES (NULL, '$rev')";
			$result = $connection->query($sql);
			if($result) 
			{
				$_SESSION['loginerror'] = "<div style='color:green;' >Opinia wysłana pomyślnie. Dzięki!</div>";
				header('Location:home');
			} else 
			{
				echo 'Nie można dodać.';
			}
		}
		
	?>
	<br />
	<br />
	<div class="box">
		<h2>Opinia</h2>
		<form method="post">
			<textarea name="review" cols="40" rows="7" placeholder="Daj znać co dodać lub zmienić na forum.."></textarea>
			<br />
			<input type="submit" class="button"/>
		</form>
	</div>
</center>
</body>
</html>