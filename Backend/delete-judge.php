<?php
session_start();
include '../Vendor/connection.php';

if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    $check = $conn->prepare("SELECT * FROM `user` WHERE userID = ? AND role = 'user'");
    $check->bind_param("i", $userID);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $delete = $conn->prepare("DELETE FROM `user` WHERE userID = ? AND role = 'user'");
        $delete->bind_param("i", $userID);

        if ($delete->execute()) {
            echo "<script>alert('Judge deleted successfully.'); window.location.href='../Administrator/Screen/Judges.php';</script>";
        } else {
            echo "<script>alert('Error deleting judge: " . $conn->error . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Judge not found or invalid role.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
