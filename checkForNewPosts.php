<?php
session_start();
require_once "connect.php";

$id = $_SESSION['id'];

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
} else {
    $result3 = mysqli_query($connection, "SELECT topic FROM topics WHERE topicid=$id");
    $topicx = mysqli_fetch_array($result3);
    $topic = $topicx['topic'];
    $result = mysqli_query($connection, "SELECT * FROM posts WHERE topicid=$id ORDER BY postid");

    if($result->num_rows !== $_SESSION['num_rows']) {
        echo '1';
    } else echo '0';

}