<?php

include "connect.php";
include "functions.php";

$userId = $_GET['userId'];
$friendId = $_GET['friendId'];

$query = "
    SELECT messages.*
    FROM messages
    JOIN chats ON messages.chat_id = chats.id
    WHERE chats.sender_id = $userId AND chats.receiver_id = $friendId
    ORDER BY messages.id DESC";
$result = executeQuery($query);

$messageHtml = '';
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['sender_id'] == $userId) {
        $messageHtml .= '
        <div class="message-container right">
            <div class="message-box right">
                <p>
                    ' . $row['text'] . '
                </p>
            </div>
            <div class="date-time-container right">
                <p>
                    ' . convertDateConvo($row['date_time']) . '
                </p>
            </div>
        </div>';
    } else {
        $messageHtml .= '
        <div class="message-container">
            <div class="message-box left">
                <p>
                    ' . $row['text'] . '
                </p>
            </div>
            <div class="date-time-container left">
                <p>
                    ' . convertDateConvo($row['date_time']) . '
                </p>
            </div>
        </div>';
    }
}

echo $messageHtml;

?>