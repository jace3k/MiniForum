<?php

function navi() {
	echo '<center>';
	echo '<div id="nav">';
	echo '	<h1>Mini Forum!</h1>';
	echo '	<nav>';
	echo '		';
	echo '			<a href="home">Home</a>';
	echo '			<a href="rank">Ranking</a>';
	echo '			<a href="rev">Opinie</a>';


	if(!isset($_SESSION['logged']) || ($_SESSION['logged'] = false) ) {
		echo '<a href="reg">Rejestracja</a>';
		echo '<div id="user" class="box">';
		$fh = fopen("changelog.txt", 'r');
		$pageText = fread($fh, 25000);
		echo nl2br($pageText);
		echo '</div>';
	} else {
		echo '<a href="logout">Wyloguj</a>';
		echo '<div id="user" class="box" >';
		echo 'Witaj <a href="user?user='.$_SESSION['user'].'"><b>'.$_SESSION['user'].'</b></a> na Mini Forum!';
		echo '<br /><a href="logout">Wyloguj</a>';
		echo '</div>';
	}
	echo '	</nav>';
	echo '	</div>';
	echo '</center>';
}
?>


	
