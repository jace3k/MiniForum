<?php
require_once "connect.php";
session_start();

$user = $_SESSION['user'];

echo '<article class="thread" style="cursor:default;">';

if($connection->connect_errno != 0) {
    echo "Error: ".$connection->connect_errno;
} else {
    $result = mysqli_query($connection,"SELECT * FROM users WHERE user='$user'");
    while($row = mysqli_fetch_array($result)) {
        $user = $row['user'];
        $email = $row['email'];
        $pcount = $row['pcount'];

        echo '<span style="color: white;">Użytkownik: </span>'.strtoupper($user);
        echo '<br /><span style="color: white;">Email: </span>'.$email;
        echo '<br /><span style="color: white;">Liczba postow: </span>'.$pcount;
    }
    if($result->num_rows == 0)
        echo 'Wyglada na to że nic tu niema :) ';
    mysqli_close($connection);
}

echo '</article>';
