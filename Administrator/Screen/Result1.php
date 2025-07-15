<?php
include '../Include/Header.php';
include '../../Vendor/connection.php';

$categoryID = 1;

// 1. Fetch judges
$judgesQuery = "SELECT userID, lastname FROM user WHERE role = 'user'";
$judgesResult = $conn->query($judgesQuery);
$judges = [];
while ($row = $judgesResult->fetch_assoc()) {
    $judges[] = $row;
}

// 2. Fetch contestants under the same category
$contestantQuery = "SELECT contestantID, name FROM contestant WHERE category_ID = ?";
$stmt2 = $conn->prepare($contestantQuery);
$stmt2->bind_param("i", $categoryID);
$stmt2->execute();
$contestantsResult = $stmt2->get_result();

// 3. Process scores per contestant
$contestantScores = [];

while ($contestant = $contestantsResult->fetch_assoc()) {
    $contestantID = $contestant['contestantID'];
    $contestantName = $contestant['name'];
    $judgeScores = [];
    $totalScore = 0;

    foreach ($judges as $judge) {
        $scoreQuery = "SELECT SUM(score) as total_score FROM scores WHERE contestant_ID = ? AND judge_ID = ?";
        $stmt3 = $conn->prepare($scoreQuery);
        $stmt3->bind_param("ii", $contestantID, $judge['userID']);
        $stmt3->execute();
        $scoreResult = $stmt3->get_result();
        $scoreRow = $scoreResult->fetch_assoc();

        $judgeScore = $scoreRow['total_score'] ?? 0;
        $totalScore += $judgeScore;
        $judgeScores[] = $judgeScore;
    }

    $average = count($judges) > 0 ? $totalScore / count($judges) : 0;

    $contestantScores[] = [
        'id' => $contestantID,
        'name' => $contestantName,
        'scores' => $judgeScores,
        'total' => $totalScore,
        'average' => $average
    ];
}

// 4. Sort by total score (descending)
usort($contestantScores, fn($a, $b) => $b['total'] <=> $a['total']);

// 5. Assign rank
$rank = 1;
$prevTotal = null;
$duplicateRankCount = 0;

foreach ($contestantScores as $i => &$contestant) {
    if ($contestant['total'] === $prevTotal) {
        $contestant['rank'] = $rank - $duplicateRankCount;
        $duplicateRankCount++;
    } else {
        $contestant['rank'] = $rank;
        $duplicateRankCount = 1;
    }
    $prevTotal = $contestant['total'];
    $rank++;
}
unset($contestant);
?>

<div class="p-4">
    <div class="d-flex justify-content-between">
        <h3>Dance Battle Result</h3>
    </div>
    <div>
        <table class="table table-striped border">
            <thead class="text-center">
                <tr>
                    <th scope="col">Candidate</th>
                    <?php foreach ($judges as $judge): ?>
                        <th scope="col"><?= htmlspecialchars($judge['lastname']) ?></th>
                    <?php endforeach; ?>
                    <th scope="col">Total</th>
                    <th scope="col">Average</th>
                    <th scope="col">Rank</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php foreach ($contestantScores as $contestant): ?>
                    <tr>
                        <td><?= htmlspecialchars($contestant['name']) ?></td>

                        <?php foreach ($contestant['scores'] as $score): ?>
                            <td><?= number_format($score, 2) ?></td>
                        <?php endforeach; ?>

                        <td><strong><?= number_format($contestant['total'], 2) ?></strong></td>
                        <td><?= number_format($contestant['average'], 2) ?></td>
                        <td><strong><?= $contestant['rank'] ?></strong></td>
                        <td class="action">
                            <button class="btn btn-sm btn-view-result" data-contestant-id="<?= $contestant['id'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-eye me-2" viewBox="0 0 16 16" role="button">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Grade 1 Raw Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column">
                    <div class="">
                        <span>Judge 1</span>
                        <table class="table" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th scope="col">Criteria 1</th>
                                    <th scope="col">Criteria 2</th>
                                    <th scope="col">Criteria 3</th>
                                    <th scope="col">Criteria 4</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>35</td>
                                    <td>35</td>
                                    <td>35</td>
                                    <td>35</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="">
                        <span>Judge 2</span>
                        <table class="table" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th scope="col">Criteria 1</th>
                                    <th scope="col">Criteria 2</th>
                                    <th scope="col">Criteria 3</th>
                                    <th scope="col">Criteria 4</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>35</td>
                                    <td>35</td>
                                    <td>35</td>
                                    <td>35</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="">
                        <span>Judge 3</span>
                        <table class="table" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th scope="col">Criteria 1</th>
                                    <th scope="col">Criteria 2</th>
                                    <th scope="col">Criteria 3</th>
                                    <th scope="col">Criteria 4</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>35</td>
                                    <td>35</td>
                                    <td>35</td>
                                    <td>35</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>

<?php include '../Include/Footer.php'; ?>