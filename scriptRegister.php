<?php
session_start();

if(isset($_POST['login'])) {
    $allok = true;

    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once "connect.php";

    if($connection->connect_errno != 0) {
        echo "Błąd: ".$connection->connect_errorno;
    } else {

        $sql = "SELECT email FROM users WHERE email='$email'"; // sprawdz czy nie ma takiego maila
        $result = $connection->query($sql);
        if($result) {
            if($result->num_rows > 0) {
                $allok = false;
                $_SESSION['loginerror'] = "Taki email już istnieje!";
            }
        }

        $sql = "SELECT user FROM users WHERE user='$login'"; // sprawdz czy nie ma takiego loginu
        $result = $connection->query($sql);
        if($result) {
            if($result->num_rows > 0) {
                $allok = false;
                $_SESSION['loginerror'] = "Taki login już istnieje!";
            }
        }

        if($allok) {
            $sql = "INSERT INTO users VALUES (NULL, '$login', '$password', '$email', '0', '0', '0')";
            $result = $connection->query($sql);
            if($result) {
                $_SESSION['loginerror'] = "Konto utworzone pomyślnie.";
            } else {
                echo 'Nie można dodać.';
            }
        }
        $connection->close();
    }
}
