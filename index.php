<?php
session_start();

include('Navi.php');

if(isset($_SESSION['logged']) && ($_SESSION['logged'] = true) ) {
    $navi->logged = 1;
    $navi->name = $_SESSION['user'];
}
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>miniForum</title>
	<meta name="description" content="Opis w Google" />
	<meta name="keywords" content="słowa, kluczowe, wypisane, po, przecinku" />
	<link rel="stylesheet" href="style.css" />
	<link rel="shortcut icon" href="favicon.ico" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="code.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:200&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>

<body>
    <?php
        $navi->printNavi();
		if(isset($_SESSION['loginerror']))	{
		    if($_SESSION['loginerror'] == "Konto utworzone pomyślnie." || $_SESSION['loginerror'] == 'Zalogowano pomyślnie.' || $_SESSION['loginerror'] == 'Wylogowano.') {
                $navi->printSuccess($_SESSION['loginerror']);
            } else {
                $navi->printError($_SESSION['loginerror']);
            }
            unset($_SESSION['loginerror']);
        };

    ?>
    <button id="backbtn" class="submit">Wróć</button>

    <div id="mainsection">
        <section id="content"></section>
    </div>
    <section id="info"></section>

    <section style="clear: both;"></section>

        <section id="send">
            <article class="thread" style="text-align: center">
                <form method="post" id="threadForm">
                    <label for="input">Dodaj temat:</label><input type="text" class="input" name="sendarea" placeholder=" napisz coś.."/>
                    <input type="submit" class="submit"/>
                </form>

                <form method="post" id="postForm">
                    <label for="input">Wiadomość:</label><input type="text" class="input" name="sendarea" placeholder=" napisz coś.."/>
                    <input type="submit" class="submit"/>
                </form>
            </article>
        </section>

    <footer>
        <p style="padding-left: 20px;">Copyright by Jacek :D</p>
    </footer>


    <div style="display: none" id="status"><?php echo $navi->logged ?></div>
</body>
</html>