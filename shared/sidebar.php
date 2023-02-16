<div class="sidebar">
    <div class="upper-icons">
        <!-- <a href="index.php"><img src="images/icons/chatbud_logo_no-text.png" class="logo" alt="logo"></a> -->

        <a href="profile.php">
            <div class="circle-container">
                <?php
                $queryImage = "SELECT image FROM users WHERE id=$userId";
                $imageResult = executeQuery($queryImage);
                $imageRow = mysqli_fetch_assoc($imageResult);
                ?>
                <img src="images/profile_pics/<?php echo $imageRow['image'] ?>" class="user-pic" alt="user-pic">
            </div>
        </a>

        <a href="index.php" class="<?php if ($pagename == "index") {
            echo "active";
        } ?>">
            <i class="fa-solid fa-inbox icons"></i>
        </a>

        <a href="users.php" class="<?php if ($pagename == "users") {
            echo "active";
        } ?>">
            <i class="fa-solid fa-user-group icons"></i>
        </a>
    </div>

    <div class="lower-icons">
        <i class="fa-solid fa-arrow-right-from-bracket icons"></i>
    </div>
</div>

<div class="black-container">
    <div class="confirm-dialog">
        <h3>Signing Out</h3>
        <p>Are you sure you want to sign out?</p>
        <div class="buttons-container">
            <button class="btn-cancel">Cancel</button>
            <a href="login.php"><button class="btn-sign-out">Sign Out</button></a>
        </div>
    </div>
</div>

<script src="js/sidebar.js"></script>