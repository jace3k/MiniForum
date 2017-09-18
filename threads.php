
<?php
session_start();

require_once "connect.php";

if(isset($_POST['sendarea']) && $_POST['sendarea'] != NULL) {
    if($connection->connect_errno != 0) {
        echo "Error:".$connection->connect_errno;
    } else {
        $sendarea = $_POST['sendarea'];
        $userid = $_SESSION['userid'];
        $date = date('d-m-Y \<H:i:s\>');

        $sql = "INSERT INTO topics VALUES (NULL,'$userid','$sendarea','$date')";
        mysqli_query($connection,$sql);
        mysqli_close($connection);
    }
} else {
    if ($connection->connect_errno != 0) {
        echo "Error: " . $connection->connect_errno;
    } else {
        $result = mysqli_query($connection, "SELECT * FROM topics");
        while ($row = mysqli_fetch_array($result)) {
            $userid = $row['userid'];
            $topicid = $row['topicid'];
            $date = $row['date'];
            $result2 = mysqli_query($connection, "SELECT user FROM users WHERE userid='$userid'");
            $userx = mysqli_fetch_array($result2);
            $user = $userx['user'];
            $topic = 'topic';
            echo <<<EOT
        <article class="thread" >
        <header onclick="myThings($topicid)">$row[$topic]</header>
        <div style="font-size: 0.7em;">$user</div>
        <div style="font-size: 0.6em;">$date</div>
        </article>
EOT;
        }
        if ($result->num_rows <= 0) {
            echo 'Wyglada na to że nic tu niema :) ';
        }
        mysqli_close($connection);
    }

    echo '</div>';
}