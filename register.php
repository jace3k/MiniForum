<?php
	session_start();

	if(isset($_POST['login'])) {
		$allok = true;
		
		// pamietanie danych //
		
		$_SESSION['r_login'] = $_POST['login'];
		$_SESSION['r_password'] = $_POST['password'];
		$_SESSION['r_password2'] = $_POST['password2'];
		$_SESSION['r_email'] = $_POST['email'];
		if(isset($_POST['rules'])) $_SESSION['r_rules'] = $_POST['rules'];
		
		//login
		$login = $_POST['login'];
		
		if(ctype_alnum($login) == false) {
			$allok = false;
			$_SESSION['e_login'] = "<div class='error'>Tylko znaki alfanumeryczne!</div>";
		}
		
		if(strlen($login) < 3 || strlen($login) > 20) {
			$allok = false;
			$_SESSION['e_login'] = "<div class='error'>Login: od 3 do 20 znaków!</div>";
		} 
		
		 
		$words = file_get_contents('words.txt');
		$words = str_replace("
","[a-z]*|[a-z]*",$words);
		$loginx = eregi_replace($words,"[CENZURA]",$login);
		if($loginx != $login) {
			$allok = false;
			$_SESSION['e_login'] = "<div class='error'>Nie możesz użyć wulgaryzmów!</div>";
		}
		
		
		
		// email
		$email = $_POST['email'];
		
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			$allok = false;
			$_SESSION['e_email'] = "<div class='error' >Niepoprawny adres e-mail!</div>";
		}
		
		// password
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		
		if(strlen($password) < 6 || strlen($password) > 30) {
			$allok = false;
			$_SESSION['e_password'] = "<div class='error'>Hasło: od 6 do 30 znaków!</div>";
		}
		
		if($password != $password2) {
			$allok = false;
			$_SESSION['e_password'] = "<div class='error'>Hasła nie są identyczne!</div>";
		}
		
		// captcha
		$captcha = $_POST['g-recaptcha-response'];
		if($captcha) {
			$secretkey = "6LcnHAoUAAAAAAft3NeTq4g4KPN7e92WqcZ4W4vd";
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretkey."&response=".$captcha);
			$responsekeys = json_decode($response,true);
			if($responsekeys['success'] != 1) {
				$allok = false;
				$_SESSION['e_captcha'] = "<div class='error'>Jesteś robotem?</div>";
			}
		} else {
			$allok = false;
			$_SESSION['e_captcha'] = "<div class='error'>Jesteś robotem?</div>";
		}
		
		
		// regulamin
		if(!isset($_POST['rules'])) {
			$allok = false;
			$_SESSION['e_rules'] = "<div class='error'>Akceptuj regulamin!</div>";
		}
		
	
	
		// tutaj będzie połączenie z bazą danych
		require_once "connect.php"; // mamy $connection.
		if($connection->connect_errno != 0) {
			echo "Błąd: ".$connection->connect_errorno;
		} else { // nawiązano połączenie z bazą //
			// sprawdz czy nie ma takiego maila
			$sql = "SELECT email FROM users WHERE email='$email'";
			$result = $connection->query($sql);
			if($result) {
				if($result->num_rows > 0) {
					$allok = false;
					$_SESSION['e_email'] = "<div class='error'>Taki email już istnieje!</div>";
				}
			}
			// sprawdz czy nie ma takiego loginu
			$sql = "SELECT user FROM users WHERE user='$login'";
			$result = $connection->query($sql);
			if($result) {
				if($result->num_rows > 0) {
					$allok = false;
					$_SESSION['e_login'] = "<div class='error'>Taki login już istnieje!</div>";
				}
			}
			
			if($allok) {
				$sql = "INSERT INTO users VALUES (NULL, '$login', '$password', '$email', '0', '0', '0')";
				$result = $connection->query($sql);
				if($result) {
					$_SESSION['loginerror'] = "<div style='color:green;' >Konto utworzone pomyślnie! Teraz możesz się zalogować!</div>";
					header('Location:home');
				} else {
					echo 'Nie można dodać.';
				}
			}
			$connection->close();
		}
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>Rejestracja</title>
	
	<meta name="description" content="Opis w Google" />
	<meta name="keywords" content="słowa, kluczowe, wypisane, po, przecinku" />
	
	<link rel="stylesheet" href="style.css" />
	
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<center>
	
	<?php
		require_once "navi.php";
		navi();
	?>
	<br />

	<br />
	
	<!-- wyświetlanie błędów -->
	<div class="box">
	
	<h2>Rejestracja</h2>
	
	
	<form method="post" action="reg">
		<table border="0" >
		<tr>
			<td>Email:</td><td><input class="podkrec5" placeholder="Podaj email..." type="text" name="email" value="<?php 
			
				if(isset($_SESSION['r_email'])) {
					echo $_SESSION['r_email'];
					unset($_SESSION['r_email']);
				}
			?>"/></td>
		</tr>
		
		<tr>
			<td>Login:</td><td><input class="podkrec5" placeholder="Podaj login..." type="text" name="login" value="<?php 
			
				if(isset($_SESSION['r_login'])) {
					echo $_SESSION['r_login'];
					unset($_SESSION['r_login']);
				}
			?>"/></td>
		</tr>
		
		<tr>
			<td>Hasło:</td><td><input class="podkrec5" placeholder="Podaj hasło..." type="password" name="password" value="<?php 
			
				if(isset($_SESSION['r_password'])) {
					echo $_SESSION['r_password'];
					unset($_SESSION['r_password']);
				}
			?>"/></td>
		</tr>
		
		<tr>
			<td>Powtórz hasło:</td><td><input class="podkrec5" placeholder="Powtórz hasło..." type="password" name="password2" value="<?php 
			
				if(isset($_SESSION['r_password2'])) {
					echo $_SESSION['r_password2'];
					unset($_SESSION['r_password2']);
				}
			?>"/></td>
		</tr>
		
		<tr align="center" >
			<td colspan="2"><div class="g-recaptcha" data-theme="dark" data-sitekey="6LcnHAoUAAAAAItIh1RLQrLjCdVXNvaGUITDZWiz"></div></td>
		</tr>
		
		<tr align="center" >
			<td colspan="2"><label><input type="checkbox" name="rules" <?php 
			
				if(isset($_SESSION['r_rules'])) {
					echo 'checked';
					unset($_SESSION['r_rules']);
				}
				
			?>/>Akceptuję nieistniejący regulamin :)</label></td>
		</tr>
		
		<tr align="center" >
			<td colspan="2"><input type="submit" value="Załóż konto" class="button" /></td>
		</tr>
		
		</table>
		
	
	</form>
	
	
	<?php 
		echo '<br />';
		if(isset($_SESSION['e_login'])) {
			echo $_SESSION['e_login'];
			unset($_SESSION['e_login']);
		}
		
		if(isset($_SESSION['e_email'])) {
			echo $_SESSION['e_email'];
			unset($_SESSION['e_email']);
		}
		
		if(isset($_SESSION['e_password'])) {
			echo $_SESSION['e_password'];
			unset($_SESSION['e_password']);
		}
		
		if(isset($_SESSION['e_rules'])) {
			echo $_SESSION['e_rules'];
			unset($_SESSION['e_rules']);
		}
		
		if(isset($_SESSION['e_captcha'])) {
			echo $_SESSION['e_captcha'];
			unset($_SESSION['e_captcha']);
		}
		
		
	?>
	<br />
	<a href="home">Home</a>
	</div>
	
	
</center>
</body>
</html>