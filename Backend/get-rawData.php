<?php
include '../Vendor/connection.php';

$contestantID = $_GET['id'] ?? 0;

// Fetch judges
$judges = [];
$judgeQuery = "SELECT userID, lastname FROM user WHERE role = 'user'";
$judgeResult = $conn->query($judgeQuery);
while ($row = $judgeResult->fetch_assoc()) {
    $judges[$row['userID']] = $row['lastname'];
}

// Fetch criteria
$criteria = [];
$criteriaQuery = "SELECT criteriaID, name FROM criteria";
$criteriaResult = $conn->query($criteriaQuery);
while ($row = $criteriaResult->fetch_assoc()) {
    $criteria[$row['criteriaID']] = $row['name'];
}

// Fetch scores
$scores = [];
$scoreQuery = "SELECT judge_ID, criterion_ID, score FROM scores WHERE contestant_ID = ?";
$stmt = $conn->prepare($scoreQuery);
$stmt->bind_param("i", $contestantID);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $judgeID = $row['judge_ID'];
    $criteriaID = $row['criterion_ID'];
    $scores[$judgeID]['lastname'] = $judges[$judgeID] ?? 'Unknown Judge';
    $scores[$judgeID]['scores'][$criteria[$criteriaID] ?? 'Unknown Criteria'] = $row['score'];
}

echo json_encode($scores);
?>
