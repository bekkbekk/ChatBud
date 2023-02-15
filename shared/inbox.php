<div class="inbox-container">
    <div class="inbox">

        <?php
        $pageTitle = "Chats";
        include "shared/header.php";
        ?>

        <div class="last-message-container">
            <!-- codes to manipulate -->
            <?php

            // first query
            $query1 = "SELECT * FROM chats WHERE sender_id=$userId ORDER BY last_updated DESC";
            $result1 = executeQuery($query1);

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
                        <img src="images/profile_pics/<?php echo $row2['image'] ?>" class="friend-pic" alt="user-pic">

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
                        <button class="btn-delete"><i class="fa-solid fa-trash"></i> DELETE</button>
                    </div>
                </div>

                <div class="delete-container">
                    <div class="confirm-delete">
                        <h3>DELETE</h3>
                        <p>Are you sure you want to delete conversation with
                            <?php echo $row2['f_name'] ?>?
                        </p>
                        <div class="buttons-container">
                            <button class="btn-cancel-del">Cancel</button>
                            <form method="POST"><button class="btn-sign-out" name="delete"
                                    value="<?php echo $chatId ?>">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
            }

            ?>
            <!-- end of code -->
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', () => {
        // confirm dialog to delete
        const confirmDialogs = document.querySelectorAll('.delete-container');
        const deleteBtns = document.querySelectorAll('.btn-delete');
        const cancelBtns = document.querySelectorAll('.btn-cancel-del');

        // deleteBtns.forEach(del => {
        //     del.addEventListener('click', (e) => {
        //         e.stopPropagation();
        //         confirmDialog.style.display = 'flex';
        //     })
        // });

        for (let i = 0; i < deleteBtns.length; i++) {
            let del = deleteBtns[i];
            del.addEventListener('click', (e) => {
                e.stopPropagation();
                confirmDialogs[i].style.display = 'flex';
            })
        }

        // cancelBtns.forEach(cancel => {
        //     cancel.addEventListener('click', () => {
        //         confirmDialog.style.display = 'none';
        //     })
        // });

        for (let i = 0; i < cancelBtns.length; i++) {
            let cancel = cancelBtns[i];
            cancel.addEventListener('click', () => {
                confirmDialogs[i].style.display = 'none';
            })
        }



    });
</script>