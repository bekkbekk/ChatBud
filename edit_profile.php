<?php
session_start();

include "shared/connect.php";
include "shared/functions.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$userId = $_SESSION['user_id'];


if (isset($_POST['update'])) {

    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $birthdate = $_POST['birthdate'];

    if ($_FILES['profpic']['name'] != "") {
        $foldername = 'images/profile_pics/';

        $filename = $_FILES['profpic']['name'];
        $fileuploadTMP = $_FILES['profpic']['tmp_name']; // Temporary storage in RAM

        $file_ext = substr($filename, strripos($filename, '.')); // .png, .jpg
        $filenewname = date("YmdHisu");

        $newfilename = $filenewname . $file_ext; // 20230213173612091243.png

        move_uploaded_file($fileuploadTMP, $foldername . $newfilename); // move file from RAM to the folder

        $query = "UPDATE users SET f_name='$f_name', l_name='$l_name', birthdate='$birthdate', image='$newfilename' WHERE id=$userId";
        executeQuery($query);
    } else {
        $query = "UPDATE users SET f_name='$f_name', l_name='$l_name', birthdate='$birthdate' WHERE id=$userId";
        executeQuery($query);
    }

    header("Location: profile.php");

    // dito na maguupdate
}

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
    <link rel="stylesheet" href="css/edit_profile.css">
    <link rel="shortcut icon" href="images/icons/chatbud_logo.png">

</head>

<body>
    <div class="header">
        <a href="profile.php"><i class="fa-solid fa-circle-arrow-left"></i></a>
        <h1>Edit Profile</h1>
        <div></div>
    </div>

    <?php
    $query = "SELECT * FROM users WHERE id=$userId";
    $result = executeQuery($query);
    $row = mysqli_fetch_assoc($result);
    ?>
    <div class="container">
        <form method="POST" enctype="multipart/form-data">
            <div class="circle-container">
                <label for="prof-pic">
                    <img src="images/profile_pics/<?php echo $row['image'] ?>" alt="profile-pic">
                </label>
            </div>
            <input type="file" accept="image/*" id="prof-pic" name="profpic">

            <div class="form-group-name">
                <input type="text" id="first-name" name="f_name" placeholder="First Name"
                    value="<?php echo $row['f_name'] ?>" required>
                <input type="text" id="last-name" name="l_name" placeholder="Last Name"
                    value="<?php echo $row['l_name'] ?>" required>
            </div>

            <div class="form-group-date">
                <input type="text" id="date" name="birthdate" placeholder="Birthdate" onfocus="(this.type='date')" onblur="(this.type='text')" required autocomplete="off" value="<?php echo $row['birthdate'] ?>">
            </div>

            <button class="btn" name="update">Save Profile</button>
        </form>
    </div>

    </form>
</body>





</html>