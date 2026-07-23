<?php
$conn = mysqli_connect(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_NAME'),
    intval(getenv('DB_PORT') ?: 3306)
);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
