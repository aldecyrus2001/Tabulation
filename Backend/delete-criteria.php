<?php
session_start();
include '../Vendor/connection.php';

if (isset($_GET['id'])) {
    $criteriaID = $_GET['id'];

    $check = $conn->prepare("SELECT * FROM `criteria` WHERE `criteriaID` = ?");
    $check->bind_param("i", $criteriaID);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $delete = $conn->prepare("DELETE FROM `criteria` WHERE `criteriaID` = ?");
        $delete->bind_param("i", $criteriaID);

        if ($delete->execute()) {
            echo "<script>alert('Criteria deleted successfully.'); window.location.href='../Administrator/Screen/Criteria.php';</script>";
        } else {
            echo "<script>alert('Error deleting criteria: " . $conn->error . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Criteria not found.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>