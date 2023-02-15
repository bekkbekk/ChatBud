<header>
    <button class="hamburger">
        <div class="bar"></div>
    </button>

    <h2 class="page-title">
        <?php echo $pageTitle ?>
    </h2>
</header>

<div class="mobile-nav-container">
    <nav class="mobile-nav">
        <ul class="upper">
            <li><a href="profile.php">Profile</a></li>
            <li class="<?php if ($pagename == "index") {
                echo "active";
            } ?>"><a href="index.php">Chats</a></li>
            <li class="<?php if ($pagename == "users") {
                echo "active";
            } ?>"><a href="users.php">Users</a></li>
        </ul>
        <ul class="lower">
            <li><a class="sign-out">Sign Out</a></li>
        </ul>
    </nav>
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

<script src="js/header.js"></script>