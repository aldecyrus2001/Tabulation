<?php
session_start();
include '../Vendor/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judgeID = $_POST['judge_id'] ?? null;
    $scores = $_POST['scores'] ?? [];

    if (!$judgeID || empty($scores)) {
        die("Missing judge ID or score data.");
    }

    foreach ($scores as $contestantID => $criteriaScores) {
        foreach ($criteriaScores as $criteriaID => $score) {
            if ($score === '' || !is_numeric($score)) {
                continue;
            }

            // Check if score already exists
            $checkQuery = "SELECT scoresID FROM scores WHERE judge_ID = ? AND contestant_ID = ? AND criterion_ID = ?";
            $stmt = $conn->prepare($checkQuery);
            $stmt->bind_param("iii", $judgeID, $contestantID, $criteriaID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Update existing score
                $updateQuery = "UPDATE scores SET score = ? WHERE judge_ID = ? AND contestant_ID = ? AND criterion_ID = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("diii", $score, $judgeID, $contestantID, $criteriaID);
                $updateStmt->execute();
            } else {
                // Insert new score
                $insertQuery = "INSERT INTO scores (judge_ID, contestant_ID, criterion_ID, score) VALUES (?, ?, ?, ?)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param("iiid", $judgeID, $contestantID, $criteriaID, $score);
                $insertStmt->execute();
            }

        }
    }

    echo "<script>alert('Score Recorded successfully.'); window.location.href='../Judges/Screen/Sheet2v2.php';</script>";
    exit;
} else {
    die("Invalid request method.");
}
?>
