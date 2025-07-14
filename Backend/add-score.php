<?php
session_start();
include '../Vendor/connection.php';

$judgeID = $_SESSION['userID'];
$contestantID = $_POST['contestant_id'];
$criteriaScores = $_POST['criteria'];

$allSuccessful = true;

foreach ($criteriaScores as $criteriaID => $score) {
    $stmt = $conn->prepare("INSERT INTO scores (judge_ID, contestant_ID, criterion_ID, score)
                            VALUES (?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE score = VALUES(score)");
    $stmt->bind_param("iiii", $judgeID, $contestantID, $criteriaID, $score);
    
    if (!$stmt->execute()) {
        $allSuccessful = false;
        error_log("Failed to insert score for criterion $criteriaID: " . $stmt->error);
    }
}

if ($allSuccessful) {
    echo "<script>alert('Score recorded successfully.'); window.location.href = '../Judges/Screen/Sheet1.php';</script>";
    exit;
} else {
    echo "<script>alert('Error recording score: " . $conn->error . "'); window.history.back();</script>";
    exit;
}
