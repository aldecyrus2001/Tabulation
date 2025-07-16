<?php

session_start();

include '../Vendor/connection.php';

$username = $_POST['username'];
$password = $_POST['password'];

$hashedPassword = md5($password);

$sql = "SELECT * FROM `user` WHERE `username` = ? AND `password` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashedPassword);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    $_SESSION['userID']     = $user['userID'];
    $_SESSION['username']   = $user['username'];
    $_SESSION['firstname']  = $user['firstname'];
    $_SESSION['middlename'] = $user['middlename'];
    $_SESSION['lastname']   = $user['lastname'];
    $_SESSION['role']       = $user['role'];

    if ($user['status'] != 'inactive') {
        if ($user['role'] === 'administrator') {
            header("Location: ../Administrator/Screen/Home.php");
        } else if ($user['role'] === 'user') {
            header("Location: ../Judges/Screen/Sheet1v2.php");
        } else {
            echo "Unknown role.";
        }
    }
    else {
        echo "<script>alert('Account Inactive, Please call Sir Cyrus!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid username or password'); window.history.back();</script>";
}

$conn->close();
