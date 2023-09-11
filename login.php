<?php
session_start();
require_once('db.php');

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."' ";
   
    $result = mysqli_query($connection, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
    } else {
        header('Location: loginform.php');
    }

    mysqli_close($connection);
}
?>