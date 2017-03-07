<?php
	session_start();
	//if(!isset($_SESSION['logged'])) $_SESSION['logged'] = false;
	if(isset($_SESSION['logged']) && ($_SESSION['logged'] = true) ) header('Location: forum');
	
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
<center>
	<?php
		require_once "navi.php";
		navi();
	?>
	<br />
	<br />
	<div class="box">
	<h2>Logowanie</h2>
	<form action="login" method="post">
		<table border=0 cellpadding=3>
			<tr>
				<td>Login:</td>
				<td><input class="podkrec5" type="text" name="login" /></td>
			</tr>
			
			<tr>
				<td>Hasło:</td>
				<td><input class="podkrec5" type="password" name="password" /></td>
			</tr>
			
			<tr>
			<td colspan=2>
				<center><input type="submit" value="Zaloguj" class="button"><center>
			</td>
			</tr>
			
			<tr>
			
		</table>
	</form>
	<br />
	<br />
	<a href="reg">Załóż konto</a>
	<br />
	
	
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