<?php
session_start();
session_destroy();
session_start();

include "shared/login_signup_head.php";

$isError = false;
$errorMessage = "";

if (isset($_POST['firstname'])) {
    $fName = $_POST['firstname'];
    $lName = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conPassword = $_POST['conpassword'];
    $birthdate = $_POST['birthdate'];

    if (emailExists($_POST['email'])) {
        $errorMessage = "The email is already taken.";
        $isError = true;
    } else {
        if (passwordMatch($password, $conPassword)) {
            signUpUser($fName, $lName, $email, $password, $birthdate);
        } else {
            $errorMessage = "Passwords do not match.";
            $isError = true;
        }
    }
}

?>

<body>
    <div class="container">
        <div class="form-container">
            <div class="signup form">
                <h2>Sign Up</h2>
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
                    <?php if (isset($_POST['firstname'])) { ?>
                        <input id="firstname" name="firstname" type="text" placeholder="First Name" maxlength="50" required
                            autocomplete="off" value="<?php echo $fName ?>">
                        <input id="lastname" name="lastname" type="text" placeholder="Last Name" maxlength="30" required
                            autocomplete="off" value="<?php echo $lName ?>">
                        <input type="text" id="date" name="birthdate" placeholder="Birthdate" onfocus="(this.type='date')"
                            onblur="(this.type='text')" required autocomplete="off" value="<?php echo $birthdate ?>">
                        <input id="email" name="email" maxlength="50" type="email" placeholder="Email" required
                            autocomplete="off" value="<?php echo $email ?>">
                        <input id="password" minlength="7" name="password" type="password" placeholder="Password"
                            maxlength="30" required autocomplete="off" value="<?php echo $password ?>">
                        <input id="conpassword" name="conpassword" minlength="7" type="password"
                            placeholder="Confirm your password" maxlength="30" required autocomplete="off"
                            value="<?php echo $conPassword ?>">
                        <input type="submit" class="button" value="Sign Up">

                    <?php } else { ?>
                        <input id="firstname" name="firstname" type="text" placeholder="First Name" maxlength="50" required
                            autocomplete="off">
                        <input id="lastname" name="lastname" type="text" placeholder="Last Name" maxlength="30" required
                            autocomplete="off">
                        <input type="text" id="date" name="birthdate" placeholder="Birthdate" onfocus="(this.type='date')"
                            onblur="(this.type='text')" required autocomplete="off">
                        <input id="email" name="email" maxlength="50" type="email" placeholder="Email" required
                            autocomplete="off">
                        <input id="password" minlength="7" name="password" type="password" placeholder="Password"
                            maxlength="30" required autocomplete="off">
                        <input id="conpassword" name="conpassword" minlength="7" type="password"
                            placeholder="Confirm your password" maxlength="30" required autocomplete="off">
                        <input type="submit" class="button" value="Sign Up">
                    <?php }

                    ?>
                </form>

                <div class="sign-up">
                    Already have an account?
                    <a href="login.php">Log In</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>