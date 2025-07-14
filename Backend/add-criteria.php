<?php
session_start();
include '../Vendor/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $categoryID = $_POST['category'];     
    $criteriaName = $_POST['criteria'];  
    $weight = $_POST['weight'];          

    if (empty($categoryID) || empty($criteriaName) || empty($weight)) {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit;
    }
    $sql = "INSERT INTO criteria (catergory_ID, name, weight) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $categoryID, $criteriaName, $weight);

    if ($stmt->execute()) {
        echo "<script>alert('Criteria added successfully.'); window.location.href='../Administrator/Screen/Criteria.php';</script>";
    } else {
        echo "<script>alert('Error adding criteria: " . $conn->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: ../Administrator/Screen/Criteria.php");
    exit;
}
