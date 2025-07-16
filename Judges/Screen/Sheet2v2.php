<?php
include '../Include/Header.php';
include '../../Vendor/connection.php';

$judgeID = $_SESSION['userID'];
$categoryID = 2;

// Fetch criteria
$criteriaQuery = "SELECT criteriaID, name, weight FROM criteria WHERE catergory_ID = ?";
$stmt = $conn->prepare($criteriaQuery);
$stmt->bind_param("i", $categoryID);
$stmt->execute();
$criteriaResult = $stmt->get_result();

$criteriaList = [];
while ($row = $criteriaResult->fetch_assoc()) {
    $criteriaList[] = $row;
}

// Fetch contestants
$contestantQuery = "SELECT contestantID, name FROM contestant WHERE category_ID = ?";
$stmt2 = $conn->prepare($contestantQuery);
$stmt2->bind_param("i", $categoryID);
$stmt2->execute();
$contestantsResult = $stmt2->get_result();

$existingScoresQuery = "SELECT contestant_ID, criterion_ID, score FROM scores WHERE judge_ID = ?";
$stmt3 = $conn->prepare($existingScoresQuery);
$stmt3->bind_param("i", $judgeID);
$stmt3->execute();
$result3 = $stmt3->get_result();

$savedScores = [];
while ($row = $result3->fetch_assoc()) {
    $savedScores[$row['contestant_ID']][$row['criterion_ID']] = $row['score'];
}
?>

<div class="p-4">
    <h3 class="mb-3">Dance Battle Score Sheet</h3>
    <form method="POST" action="../../Backend/add-score-bulk2.php">
        <input type="hidden" name="judge_id" value="<?= $judgeID ?>">

        <table class="table text-center table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Contestant</th>
                    <?php foreach ($criteriaList as $crit): ?>
                        <th><?= htmlspecialchars($crit['name']) ?> (<?= $crit['weight'] ?>%)</th>
                    <?php endforeach; ?>
                    <th>Total</th>
                    <th>Ranking</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($contestant = $contestantsResult->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($contestant['name']) ?>
                            <input type="hidden" name="contestants[]" value="<?= $contestant['contestantID'] ?>">
                        </td>
                        <?php foreach ($criteriaList as $crit): ?>
                            <td>
                                <?php
                                $existingValue = $savedScores[$contestant['contestantID']][$crit['criteriaID']] ?? '';
                                ?>
                                <input type="number"
                                    name="scores[<?= $contestant['contestantID'] ?>][<?= $crit['criteriaID'] ?>]"
                                    class="text-center score-input"
                                    min="0" max="100" step="0.01"
                                    data-weight="<?= $crit['weight'] ?>"
                                    value="<?= htmlspecialchars($existingValue) ?>"
                                    required>
                            </td>
                        <?php endforeach; ?>
                        <td class="total-cell">0.00</td>
                        <td class="rank-cell">-</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>


        <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-primary">Save All Scores</button>
        </div>
    </form>
</div>

<script>
    function calculateRowTotal(row) {
        let total = 0;
        row.querySelectorAll('.score-input').forEach(cellInput => {
            const val = parseFloat(cellInput.value) || 0;
            total += val;
        });
        const totalCell = row.querySelector('.total-cell');
        totalCell.textContent = total.toFixed(2);
    }

    function updateAllTotalsAndRanks() {
        const rows = Array.from(document.querySelectorAll('tbody tr'));

        // First calculate totals
        rows.forEach(row => calculateRowTotal(row));

        // Sort rows by total (descending)
        const sortedRows = [...rows].sort((a, b) => {
            const totalA = parseFloat(a.querySelector('.total-cell').textContent) || 0;
            const totalB = parseFloat(b.querySelector('.total-cell').textContent) || 0;
            return totalB - totalA;
        });

        // Assign ranks
        sortedRows.forEach((row, index) => {
            const rankCell = row.querySelector('.rank-cell');
            rankCell.textContent = index + 1;
        });
    }

    // Initialize totals and ranks on page load
    updateAllTotalsAndRanks();

    // Add event listeners
    document.querySelectorAll('.score-input').forEach(input => {
        input.addEventListener('blur', function () {
            const maxAllowed = parseFloat(this.dataset.weight);
            const currentVal = parseFloat(this.value) || 0;

            if (currentVal > maxAllowed) {
                alert(`Input exceeds the allowed maximum of ${maxAllowed} for this criterion.`);
                this.value = '';
                this.focus();
            }
        });

        input.addEventListener('input', function () {
            updateAllTotalsAndRanks();
        });
    });
</script>




<?php include '../Include/Footer.php'; ?>