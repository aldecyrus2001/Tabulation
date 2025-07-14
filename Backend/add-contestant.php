<?php
session_start();
include '../Vendor/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $categoryID = $_POST['category'];

    if (empty($name) || empty($categoryID)) {
        echo "<script>alert('Please fill in all fields.'); window.history.back();</script>";
        exit;
    }

    $sql = "INSERT INTO contestant (name, category_ID) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $categoryID);

    if ($stmt->execute()) {
        echo "<script>alert('Contestant added successfully.'); window.location.href='../Administrator/Screen/Contestant.php';</script>";
    } else {
        echo "<script>alert('Error adding contestant: " . $conn->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../Administrator/Screen/Contestant.php");
    exit;
}
