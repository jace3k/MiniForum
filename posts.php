<?php
session_start();
require_once "connect.php";

if(isset($_POST['sendarea']) && $_POST['sendarea'] != NULL) {
    if ($connection->connect_errno != 0) {
        echo "Error:" . $connection->connect_errno;
    } else {
        $sendarea = $_POST['sendarea'];
        $userid = $_SESSION['userid'];
        $id = $_GET['id'];
        $date = date('d-m-Y \<H:i:s\>');

        $sql = "INSERT INTO posts VALUES (NULL,'$userid','$id','$sendarea','$date')";
        mysqli_query($connection, $sql);

        if($connection->connect_errno != 0) {
            echo "Error: ".$connection->connect_errno;
        } else {
            $result = mysqli_query($connection,"SELECT pcount FROM users WHERE userid='$userid'");
            $row = mysqli_fetch_array($result);
            $pcount = $row['pcount'];
            $pcount++;
            mysqli_query($connection,"UPDATE users SET pcount='$pcount' WHERE userid='$userid'");
        }
    }
}

//////////////////////////////////////////////////////////////////////////////////////////

$id = $_GET['id'];
$_SESSION['id'] = $id;

echo '<article class="open">';

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
} else {
    $result3 = mysqli_query($connection, "SELECT topic FROM topics WHERE topicid=$id");
    $topicx = mysqli_fetch_array($result3);
    $topic = $topicx['topic'];
    $result = mysqli_query($connection, "SELECT * FROM posts WHERE topicid=$id ORDER BY postid");
    $_SESSION['num_rows'] = $result->num_rows;
    echo "<header style=' top: 0; margin: 0 auto;'>$topic</header>";
    while ($row = mysqli_fetch_array($result)) {
        $userid = $row['userid'];
        $post = $row['post'];
        $date = $row['date'];
        $result2 = mysqli_query($connection, "SELECT user FROM users WHERE userid='$userid'");
        $userx = mysqli_fetch_array($result2);
        $user = $userx['user'];

        echo <<<EOT
            <div class="post">
                <div class="nick">$user</div>
                <div class="msg">$post</div>
                <div class="date">$date</div>
            </div>
EOT;
    }
    if ($result->num_rows <= 0) {
        echo 'Wyglada na to że nic tu niema :) ';
    }


    mysqli_close($connection);

}
echo '<a id="down"></a>';
echo '</article>';

