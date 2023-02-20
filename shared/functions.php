<?php

function passwordMatch($password, $conPassword)
{
    if ($password === $conPassword)
        return true;
    return false;
}

function emailExists($email)
{
    $query = "SELECT email FROM users";
    $result = executeQuery($query);

    while ($row = mysqli_fetch_assoc($result)) {
        if ($email == $row['email']) {
            return true;
        }
    }

    return false;
}

function signUpUser($fName, $lName, $email, $password, $birthdate)
{
    $insertquery = "INSERT INTO users (f_name, l_name, email, password, birthdate) VALUES ('$fName', '$lName', '$email', '$password', '$birthdate')";
    executeQuery(($insertquery));

    $_SESSION['email'] = $email;
    header("Location: index.php"); // main page
}

function loginUser($email, $password)
{
    $query = "SELECT id, email, password FROM users WHERE email='$email' AND password='$password'";
    $result = executeQuery($query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($password == $row['password']) { // case-sensitive
            return $row['id']; // returns the id of the user
        }
    }

    return 0; // returns 0 if failed
}

function convertDate($date_time)
{
    $array = explode(' ', $date_time);
    $date_string = $array[0];
    $time_string = $array[1];
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d");
    // echo $date;

    if ($date_string == $date) {
        return date("g:i A", strtotime($time_string));
    } else {
        return date("F d, Y", strtotime($date_string));
    }
}

function convertDateConvo($date_time)
{
    $array = explode(' ', $date_time);
    $date_string = $array[0];
    $time_string = $array[1];

    return date("M d, Y", strtotime($date_string)) . ' AT ' . date("g:i A", strtotime($time_string));
}

function convertBirthdate($date)
{
    return date("F d, Y", strtotime($date));
}

?>