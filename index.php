<?php
session_start();

include "shared/connect.php";
include "shared/functions.php";

$userId;
$userFName;
$userLName;
$userImage;

if (isset($_SESSION['id'])) { // kapag mula sa login
    $sessionId = $_SESSION['id'];
    $query = "SELECT f_name, l_name, image FROM users WHERE id=$sessionId";
    $result = executeQuery($query);
    $row = mysqli_fetch_assoc($result);

    $userId = $sessionId;
    $userFName = $row['f_name'];
    $userLName = $row['l_name'];
    $userImage = $row['image'];

    $_SESSION['user_id'] = $sessionId;

} else if (isset($_SESSION['email'])) { // kapag mula sa signup
    $sessionEmail = $_SESSION['email'];
    $query = "SELECT id, f_name, l_name, image FROM users WHERE email='$sessionEmail'";
    $result = executeQuery($query);
    $row = mysqli_fetch_assoc($result);

    $userId = $row['id'];
    $userFName = $row['f_name'];
    $userLName = $row['l_name'];
    $userImage = $row['image'];

    $_SESSION['user_id'] = $row['id'];

} else { // kapag di pa logged in
    header("Location: login.php");
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
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/confirm_dialog.css">
    <link rel="shortcut icon" href="images/icons/ChatBud.png">

</head>

<body>
    <?php
    $pagename = "index";
    include "shared/sidebar.php";
    include "shared/inbox.php";
    ?>
</body>

</html>