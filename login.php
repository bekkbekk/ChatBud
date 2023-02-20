<?php
session_start();
session_destroy();
session_start();

include "shared/connect.php";
include "shared/functions.php";

$isError = false;
$errorMessage = "";

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id = loginUser($email, $password);

    if ($id > 0) {
        $_SESSION['id'] = $id;
        header("Location: index.php"); // main page
    } else {
        $errorMessage = "Wrong log in credentials.";
        $isError = true;
    }
}

include "shared/login_signup_head.php";
?>

<body>
    <div class="container">
        <div class="form-container">
            <div class="login form">
                <h2>Log in</h2>
                <?php if ($isError) {
                    ?>
                    <!-- only shows if there is an error -->
                    <div class="error-message">
                        <h5>
                            <?php echo $errorMessage ?>
                        </h5>
                    </div>

                    <?php
                } ?>
                <form method="POST" autocomplete="off">
                    <?php
                    if (isset($_POST['email'])) { ?>
                        <input id="email" name="email" type="email" placeholder="Email" maxlength="50" required
                            value="<?php echo $email ?>">
                        <input id="password" name="password" type="password" maxlength="30" placeholder="Password" required
                            value="<?php echo $password ?>">
                        <input type="submit" class="button" value="Log In">
                    <?php } else { ?>
                        <input id="email" name="email" type="email" placeholder="Email" maxlength="50" required>
                        <input id="password" name="password" type="password" maxlength="30" placeholder="Password" required>
                        <input type="submit" class="button" value="Log In">
                    <?php } ?>
                </form>

                <div class="sign-up">
                    Don't have an account?
                    <a href="signup.php">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>