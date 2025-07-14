<?php
include '../Vendor/connection.php';
session_start();

$firstname        = $_POST['firstname'];
$middlename       = $_POST['middlename'];
$lastname         = $_POST['lastname'];
$username         = $_POST['username'];
$password         = $_POST['password'];
$confirmpassword  = $_POST['confirmpassword'];

if ($password !== $confirmpassword) {
    echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
    exit;
}

$hashedPassword = md5($password);

$sql = "INSERT INTO user (firstname, middlename, lastname, username, password, role, status) 
        VALUES (?, ?, ?, ?, ?, 'user', 'active')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $firstname, $middlename, $lastname, $username, $hashedPassword);

if ($stmt->execute()) {
    echo "<script>alert('Judge added successfully.'); window.location.href = '../Administrator/Screen/Judges.php';</script>";
} else {
    echo "<script>alert('Error adding judge: " . $conn->error . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();


?>