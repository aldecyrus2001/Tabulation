<?php
session_start();
include '../Vendor/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_POST['userID'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $sql = "UPDATE `user` 
            SET firstname = ?, middlename = ?, lastname = ?, username = ? 
            WHERE userID = ? AND role = 'user'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $firstname, $middlename, $lastname, $username, $userID);

    if ($stmt->execute()) {
        echo "<script>alert('Judge updated successfully.'); window.location.href='../Administrator/Screen/Judges.php';</script>";
    } else {
        echo "<script>alert('Error updating judge: " . $conn->error . "'); window.history.back();</script>";
    }

    exit;
} else {
    // Block access if not POST
    header("HTTP/1.1 405 Method Not Allowed");
    echo "Method Not Allowed";
}
?>
