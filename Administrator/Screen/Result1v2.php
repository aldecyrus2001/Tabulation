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
                    <th scope="col">Contestant</th>
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
                            <button class="btn btn-sm btn-view-result" data-contestant-id="<?= $contestant['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="View">

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


<div class="modal fade" id="rawScoreModal" tabindex="-1" aria-labelledby="rawScoreModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rawScoreModalLabel">Raw Scores</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="raw-score-body">
        <!-- Dynamic content goes here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = new bootstrap.Modal(document.getElementById('rawScoreModal'));
    const body = document.getElementById('raw-score-body');

    document.querySelectorAll('.btn-view-result').forEach(button => {
        button.addEventListener('click', async () => {
            const contestantID = button.getAttribute('data-contestant-id');
            const res = await fetch(`../../Backend/get-rawData.php?id=${contestantID}`);
            const data = await res.json();

            const allCriteria = new Set();
            for (const judge of Object.values(data)) {
                for (const critName of Object.keys(judge.scores)) {
                    allCriteria.add(critName);
                }
            }
            const criteriaList = Array.from(allCriteria);

            let html = `<table class="table table-bordered table-sm" style="font-size: 13px; text-align: center;"><thead><tr>`;
            html += `<th style="width: 100px;"></th>`;
            criteriaList.forEach(crit => html += `<th>${crit}</th>`);
            html += `</tr></thead><tbody>`;

            // Table body (rows = judges)
            for (const judge of Object.values(data)) {
                html += `<tr><td>${judge.lastname}</td>`;
                criteriaList.forEach(crit => {
                    const score = judge.scores[crit] ?? '-';
                    html += `<td>${score}</td>`;
                });
                html += `</tr>`;
            }

            html += `</tbody></table>`;
            body.innerHTML = html || `<p class="text-muted">No data available for this contestant.</p>`;
            modal.show();
        });
    });
});
</script>



<?php include '../Include/Footer.php'; ?>