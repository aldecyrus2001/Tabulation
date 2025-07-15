<?php
session_start();
include '../Vendor/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contestantID = $_POST['contestantID'] ?? null;
    $name = $_POST['name'] ?? '';
    $categoryID = $_POST['category'] ?? null;

    if ($contestantID && $name && $categoryID) {
        $stmt = $conn->prepare("UPDATE contestant SET name = ?, category_ID = ? WHERE contestantID = ?");
        $stmt->bind_param("sii", $name, $categoryID, $contestantID);

        if ($stmt->execute()) {
            echo "<script>alert('Contestant updated successfully.'); window.location.href='../Administrator/Screen/Contestant.php';</script>";
        } else {
            echo "<script>alert('Error updating contestant: " . $conn->error . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo "Method Not Allowed";
}

?>