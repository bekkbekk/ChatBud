<?php
session_start();

include "shared/connect.php";

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

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- styles -->
    <link rel="stylesheet" href="css/user.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/confirm_dialog.css">
    <link rel="shortcut icon" href="images/icons/ChatBud.png">

</head>

<body>

    <?php
    $pagename = "users";
    include "shared/sidebar.php" ?>

    <!-- users page -->
    <?php
    $pageTitle = "Users";
    include "shared/header.php";
    ?>

    <div class="search-bar-container">
        <form onsubmit="return validateForm()">
            <input type="text" id="search" name="search" placeholder="Search users" required>
            <button class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <div class="users-container">
        <?php
        $query;
        $search;

        if (isset($_GET['search'])) {
            $search = trim($_GET['search']);
            $query = "SELECT * FROM users WHERE CONCAT(f_name, ' ', l_name) LIKE '%$search%' AND NOT id = $userId ORDER BY f_name";
        } else {
            $query = "SELECT * FROM users WHERE NOT id = $userId ORDER BY f_name";
        }
        $result = executeQuery($query);

        if (mysqli_num_rows($result) > 0) {
            if (isset($_GET['search'])) {
                ?>

                <div class="search-results-label">
                    Search results from "<?php echo $search ?>"
                </div>

                <?php
            }

            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <a href="conversation.php?id=<?php echo $row['id'] ?>">
                    <div class="container">
                        <div class="friend-circle-container">
                            <img src="images/profile_pics/<?php echo $row['image'] ?>" class="friend-pic">
                        </div>
                        <h2>
                            <?php echo $row['f_name'] . ' ' . $row['l_name'] ?>
                        </h2>
                    </div>
                </a>
                <?php
            }
        } else {
            ?>

            <div class="empty-message">
                <p>
                    <?php
                    if (isset($_GET['search'])) {
                        echo "No \"$search\" found.";
                    } else {
                        echo "There are no other users yet.";
                    }
                    ?>
                </p>
            </div>

            <?php
        }
        ?>
    </div>

    <script>
        function validateForm() {
            var inputVal = document.getElementById("search").value.trim();
            if (inputVal === "") {
                return false; // prevent form submission
            }
            return true; // allow form submission
        }
    </script>
</body>

</html>