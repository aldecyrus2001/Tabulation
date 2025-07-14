<?php
include '../Include/Header.php';
include '../../Vendor/connection.php';

$categoryID = 2;

// 1. Fetch criteria under the category
$criteriaQuery = "SELECT criteriaID, name, weight FROM criteria WHERE catergory_ID = ?";
$stmt = $conn->prepare($criteriaQuery);
$stmt->bind_param("i", $categoryID);
$stmt->execute();
$criteriaResult = $stmt->get_result();

// Store criteria in an array for reuse in the body
$criteriaList = [];
while ($row = $criteriaResult->fetch_assoc()) {
    $criteriaList[] = $row;
}

// 2. Fetch contestants under the same category
$contestantQuery = "SELECT contestantID, name FROM contestant WHERE category_ID = ?";
$stmt2 = $conn->prepare($contestantQuery);
$stmt2->bind_param("i", $categoryID);
$stmt2->execute();
$contestantsResult = $stmt2->get_result();
?>
<div class="p-4">
    <div class="d-flex justify-content-between">
        <h3>Dance Battle Result</h3>
    </div>
    <div class="">
        <table class="table table-striped border">
            <thead class="text-center">
                <tr>
                    <th scope="col">Candidate</th>
                    <?php foreach ($criteriaList as $crit): ?>
                        <th scope="col"><?= htmlspecialchars($crit['name']) . ' - ' . $crit['weight'] . '%' ?></th>
                    <?php endforeach; ?>
                    <th scope="col">Total</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php while ($contestant = $contestantsResult->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($contestant['name']) ?></td>

                        <?php
                        $totalScore = 0; // Total weighted score
                        foreach ($criteriaList as $crit):
                            $scoreQuery = "
                                SELECT AVG(score) as average_score
                                FROM scores
                                WHERE contestant_ID = ? AND criterion_ID = ?
                            ";
                            $stmt3 = $conn->prepare($scoreQuery);
                            $stmt3->bind_param("ii", $contestant['contestantID'], $crit['criteriaID']);
                            $stmt3->execute();
                            $scoreResult = $stmt3->get_result();
                            $scoreRow = $scoreResult->fetch_assoc();

                            $averageScore = isset($scoreRow['average_score']) ? $scoreRow['average_score'] : null;

                            if ($averageScore !== null) {
                                $weightedScore = $averageScore * ($crit['weight'] / 100);
                                $totalScore += $weightedScore;
                                echo '<td>' . round($averageScore, 2) . '</td>';
                            } else {
                                echo '<td>-</td>';
                            }
                        endforeach;
                        ?>

                        <td><strong><?= number_format($totalScore, 2) ?></strong></td>

                        <td class="action">
                            <a href="viewResult.php?id=<?= $contestant['contestantID'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-eye me-2" viewBox="0 0 16 16" role="button">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                    </svg>
                                </a>
                        </td>
                    </tr>
                <?php endwhile; ?>

            </tbody>
        </table>
    </div>
</div>

<?php include '../Include/Footer.php' ?>