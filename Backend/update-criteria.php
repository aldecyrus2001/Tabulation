<?php
session_start();
include '../Vendor/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $criteriaID = $_POST['criteriaID'] ?? null;
    $categoryID = $_POST['category'] ?? null;
    $criteriaName = $_POST['criteria'] ?? null;
    $weight = $_POST['weight'] ?? null;

    if ($criteriaID && $categoryID && $criteriaName && $weight !== null) {
        $stmt = $conn->prepare("UPDATE criteria SET name = ?, weight = ?, catergory_ID = ? WHERE criteriaID = ?");
        $stmt->bind_param("siii", $criteriaName, $weight, $categoryID, $criteriaID);

        if ($stmt->execute()) {
            echo "<script>alert('Criteria updated successfully.'); window.location.href='../Administrator/Screen/Criteria.php';</script>";
        } else {
            echo "<script>alert('Error updating criteria: " . $conn->error . "'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Missing required fields.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}
?>