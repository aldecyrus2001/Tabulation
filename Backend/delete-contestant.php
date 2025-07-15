<?php
session_start();

include '../Vendor/connection.php';
if (isset($_GET['id'])) {
    $contestantID = $_GET['id'];

    $check = $conn->prepare("SELECT * FROM contestant WHERE contestantID = ?");
    $check->bind_param("i", $contestantID);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $delete = $conn->prepare("DELETE FROM contestant WHERE contestantID = ?");
        $delete->bind_param("i", $contestantID);

        if ($delete->execute()) {
            echo "<script>alert('Contestant deleted successfully.'); window.location.href='../Administrator/Screen/Contestant.php';</script>";
        } else {
            echo "<script>alert('Error deleting contestant: " . $conn->error . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Contestant not found.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>