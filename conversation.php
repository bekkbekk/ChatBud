<?php
session_start();

include "shared/connect.php";
include "shared/functions.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$userId = $_SESSION['user_id'];
$userImage;
$friendId;
$friendFName;
$friendLName;
$friendImage;

if (isset($_GET['id'])) {
    $friendId = $_GET['id'];

    $query = "SELECT f_name, l_name, image FROM users WHERE id=$friendId";
    $result = executeQuery($query);

    // kapag minanual type yung link at invalid ang nilgay na id
    if (mysqli_num_rows($result) <= 0 || $userId == $_GET['id']) {
        header("Location: index.php");
    }

    $row = mysqli_fetch_assoc($result);

    $friendFName = $row['f_name'];
    $friendLName = $row['l_name'];
    $friendImage = $row['image'];
} else {
    header("Location: index.php");
}

if (isset($_POST['text'])) {
    $text = $_POST['text'];
    $friendId = $_GET['id'];
    $chatIdUserSender;
    $chatIdUserReceiver;

    if (trim($text) == "") {
        $text = "👍";
    }

    // check kung meron nang existing chat room vice versa
    $query1 = "SELECT id FROM chats WHERE sender_id=$userId AND receiver_id=$friendId";
    $result1 = executeQuery($query1);
    if (mysqli_num_rows($result1) > 0) {
        // get the chat id
        $row1 = mysqli_fetch_assoc($result1);
        $chatIdUserSender = $row1['id'];

        // update ang last_updated
        $datetime = date("Y-m-d H:i:s");
        $updateQuery = "UPDATE chats SET last_updated='$datetime' WHERE id=$chatIdUserSender";
        executeQuery($updateQuery);
    } else {
        // insert chat row and get chat id
        $insertQuery = "INSERT INTO chats(sender_id, receiver_id) VALUES ($userId, $friendId)";
        executeQuery($insertQuery);

        $query2 = "SELECT id FROM chats WHERE sender_id=$userId AND receiver_id=$friendId";
        $result2 = executeQuery($query2);
        $row2 = mysqli_fetch_assoc($result2);
        $chatIdUserSender = $row2['id'];
    }


    $query3 = "SELECT id FROM chats WHERE sender_id=$friendId AND receiver_id=$userId";
    $result3 = executeQuery($query3);
    if (mysqli_num_rows($result3) > 0) {
        // get the chat id
        $row3 = mysqli_fetch_assoc($result3);
        $chatIdUserReceiver = $row3['id'];

        // update ang last_updated
        $datetime = date("Y-m-d H:i:s");
        $updateQuery = "UPDATE chats SET last_updated='$datetime' WHERE id=$chatIdUserReceiver";
        executeQuery($updateQuery);
    } else {
        // insert chat row and get chat id
        $insertQuery = "INSERT INTO chats(sender_id, receiver_id) VALUES ($friendId, $userId)";
        executeQuery($insertQuery);

        $query4 = "SELECT id FROM chats WHERE sender_id=$friendId AND receiver_id=$userId";
        $result4 = executeQuery($query4);
        $row4 = mysqli_fetch_assoc($result4);
        $chatIdUserReceiver = $row4['id'];
    }

    // insert messages both room
    $text = mysqli_real_escape_string($conn, $text);
    $insertQuery2 = "INSERT INTO messages (chat_id, sender_id, text) VALUES ($chatIdUserSender, $userId, '$text'), ($chatIdUserReceiver, $userId, '$text')";
    executeQuery($insertQuery2);

    // para di nauulit yung message kapag nirerefresh
    header("Location: conversation.php?id=$friendId");
    exit;
}

if (isset($_POST['delete'])) {
    $chatId = $_POST['delete'];

    $query = "DELETE FROM chats WHERE id=$chatId";
    executeQuery($query);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatBud</title>

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- styles -->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/convo.css">
    <link rel="stylesheet" href="css/confirm_dialog.css">
    <link rel="shortcut icon" href="images/icons/ChatBud.png">

</head>

<body>
    <?php
    $pagename = "index";
    include "shared/sidebar.php";
    ?>

    <div class="column-container">
        <div class="col1">
            <?php include "shared/inbox.php"; ?>
        </div>

        <div class="col2">
            <div class="header">
                <a href="index.php"><i class="fa-solid fa-circle-arrow-left"></i></a>
                <div class="friend-circle-container">
                    <img src="images/profile_pics/<?php echo $friendImage ?>" alt="friend-pic">
                </div>
                <h3>
                    <?php echo $friendFName . ' ' . $friendLName ?>
                </h3>
            </div>

            <div class="content" id="all-message-container">

                <?php

                $query = "
                SELECT messages.*
                FROM messages
                JOIN chats ON messages.chat_id = chats.id
                WHERE chats.sender_id = $userId AND chats.receiver_id = $friendId
                ORDER BY messages.id DESC";
                $result = executeQuery($query);

                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['sender_id'] == $userId) {
                        ?>
                        <div class="message-container right">
                            <div class="message-box right">
                                <p>
                                    <?php echo nl2br(trim($row['text'])) ?>
                                </p>
                            </div>
                            <div class="date-time-container right">
                                <p>
                                    <?php echo convertDateConvo($row['date_time']) ?>
                                </p>
                            </div>
                        </div>
                    <?php } else { ?>

                        <div class="message-container">
                            <div class="message-box left">
                                <p>
                                    <?php echo nl2br(trim($row['text'])) ?>
                                </p>
                            </div>
                            <div class="date-time-container left">
                                <p>
                                    <?php echo convertDateConvo($row['date_time']) ?>
                                </p>
                            </div>
                        </div>

                        <?php
                    }
                }
                ?>
            </div>

            <form method="POST" id="message-form">
                <div class="input-container">
                    <textarea id="message-content" name="text" placeholder="Type a message..." autocomplete="off"
                        maxlength="255" autofocus></textarea>
                    <button>Send</button>
                </div>
            </form>
        </div>

    </div>
</body>

<script>
    // Enter to Submit
    window.addEventListener('load', () => {
        let form = document.getElementById("message-form");
        let textarea = document.getElementById("message-content");

        textarea.addEventListener("keydown", (event) => {
            if (event.key === "Enter" && event.shiftKey) {
                // do nothing
            } else if (event.key === "Enter") {
                event.preventDefault();  // prevent new line in textarea
                form.submit();  // submit the form
            }
        });
    });


    // AJAX
    function getNewMessage() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("all-message-container").innerHTML = xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET", "shared/updated_convo.php?userId=<?php echo $userId ?>&friendId=<?php echo $friendId ?>", true);

        xmlhttp.send();
    }

    // set a timer to execute the getNewMessage function every 500ms
    setInterval(getNewMessage, 500);
</script>

</html>