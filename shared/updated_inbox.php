<?php
session_start();

include "connect.php";
include "functions.php";

$userId = $_SESSION['id'];

// first query
$query1 = "SELECT * FROM chats WHERE sender_id=$userId ORDER BY last_updated DESC";
$result1 = executeQuery($query1);

if (mysqli_num_rows($result1) > 0) {

    while ($row1 = mysqli_fetch_assoc($result1)) {
        $chatId = $row1['id'];
        $receiverId = $row1['receiver_id'];

        // second query
        // kukunin yung info ng kachat
        $query2 = "SELECT f_name, l_name, image FROM users WHERE id=$receiverId";
        $result2 = executeQuery($query2);
        $row2 = mysqli_fetch_assoc($result2);

        // third query
        // kukunin yung details ng last message mo sa kachat mo
        $query3 = "SELECT * FROM messages WHERE chat_id = $chatId ORDER BY id DESC LIMIT 1;";
        $result3 = executeQuery($query3);
        $row3 = mysqli_fetch_assoc($result3);
        ?>

        <div class="container" onclick="window.location='conversation.php?id=<?php echo $receiverId ?>'">

            <div class="detail-message">
                <div class="inbox-circle-container">
                    <img src="images/profile_pics/<?php echo $row2['image'] ?>" class="friend-pic" alt="user-pic">
                </div>

                <div class="content">
                    <h3 class="name">
                        <?php echo $row2['f_name'] . ' ' . $row2['l_name'] ?>
                    </h3>
                    <p class="message">
                        <?php
                        if ($row3['sender_id'] == $userId)
                            echo "You: ";
                        echo $row3['text']
                            ?>
                    </p>
                    <p class="date-time">
                        <?php echo convertDate($row3['date_time']) ?>
                    </p>
                </div>
            </div>

            <div class="delete-icon">
                <button class="btn-delete" value="<?php echo $chatId ?>"><i class="fa-solid fa-trash"></i> DELETE
                </button>
            </div>
        </div>

        <?php
    }
} else {
    ?>

    <div class="empty-message">
        <p>There are no messages in your inbox yet. Start a conversation to see your messages here.</p>
    </div>


    <?php
}

?>