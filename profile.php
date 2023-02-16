<?php
session_start();

include "shared/connect.php";
include "shared/functions.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$userId = $_SESSION['user_id'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatBud</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- styles -->
    <link rel="stylesheet" href="css/profile.css">
    <link rel="shortcut icon" href="images/icons/chatbud_logo.png">

</head>

<body>
    <!-- profile page -->
    <div class="header">
        <a href="index.php"><i class="fa-solid fa-circle-arrow-left"></i></a>
        <h1>Profile</h1>
        <div></div>
    </div>

    <div class="content">
        <?php
        $query = "SELECT * FROM users WHERE id=$userId";
        $result = executeQuery($query);
        $row = mysqli_fetch_assoc($result);
        ?>

        <div class="circle-container">
            <img src="./images/profile_pics/<?php echo $row['image'] ?>">
        </div>

        <h2>
            <?php echo $row['f_name'] . ' ' . $row['l_name'] ?>
        </h2>

        <div class="date">
            <i class="fa fa-birthday-cake" aria-hidden="true"></i>
            <h6>
                <?php echo convertBirthdate($row['birthdate']) ?>
            </h6>
        </div>
        <a href="edit_profile.php" class="btn">Edit Profile</a>
    </div>
</body>

</html>