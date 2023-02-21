<div class="inbox-container">
    <div class="inbox">

        <?php
        $pageTitle = "Chats";
        include "shared/header.php";
        ?>

        <div class="last-message-container" id="last-message-container">
            <!-- codes to manipulate -->
            <?php

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

                    <div class="container <?php if (isset($_GET['id']) && $_GET['id'] == $receiverId)
                        echo "active-convo" ?>"
                            onclick="window.location='conversation.php?id=<?php echo $receiverId ?>'">

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
            <!-- end of code -->
        </div>
    </div>
</div>

<div class="delete-container black-container">
    <div class="confirm-delete confirm-dialog-box">
        <h3>DELETE</h3>
        <p>Are you sure you want to delete conversation with </p>
        <div class="buttons-container">
            <button class="btn-cancel-del btn-negative">Cancel</button>
            <form method="POST">
                <button class="btn-confirm-del btn-positive" name="delete">Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', () => {
        // confirm dialog to delete
        const deleteBtns = document.querySelectorAll('.btn-delete');
        const confirmDialog = document.querySelector('.delete-container');
        const cancelBtn = document.querySelector('.btn-cancel-del');
        const confirmDelBtn = document.querySelector('.btn-confirm-del');
        const messageToDelete = confirmDialog.querySelector('p');

        deleteBtns.forEach(del => {
            del.addEventListener('click', (e) => {
                e.stopPropagation();
                confirmDialog.style.display = 'flex';
                confirmDelBtn.value = del.value;
                let name = del.parentElement.previousElementSibling.querySelector('.name').innerHTML;
                messageToDelete.innerHTML += name + "?";
            })
        })

        cancelBtn.addEventListener('click', () => {
            confirmDialog.style.display = 'none';
            messageToDelete.innerHTML = "Are you sure you want to delete conversation with ";
        })

    });

    // AJAX
    function getNewInbox() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("last-message-container").innerHTML = xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET", "shared/updated_inbox.php<?php if (isset($_GET['id'])) echo "?id=" . $_GET['id'] ?>", true);
            xmlhttp.send();
        }

        // set a timer to execute the getNewInbox function every 5000ms
        setInterval(getNewInbox, 5000);
    </script>