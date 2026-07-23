<?php
include('db_connect.php');

$error = "";
$name = $email = $password = $confirm_password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);

    if ($name == "" || $email == "" || $password == "" || $confirm_password == "") {
        $error = "All fields are required.";
    } else {
        if ($password !== $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            $sql = "INSERT INTO users (username, email, password) VALUES ('$name', '$email', '$password')";
            if (mysqli_query($conn, $sql)) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Email already registered.";
                
            }
        }
    }
}
?>
