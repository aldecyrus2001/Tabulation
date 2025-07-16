<?php
include '../Include/Header.php';
include '../../Vendor/connection.php';
$judgeID = $_SESSION['userID'];

$categoryID = 1;

$criteriaQuery = "SELECT criteriaID, name, weight FROM criteria WHERE catergory_ID = ?";
$stmt = $conn->prepare($criteriaQuery);
$stmt->bind_param("i", $categoryID);
$stmt->execute();
$criteriaResult = $stmt->get_result();

$criteriaList = [];
while ($row = $criteriaResult->fetch_assoc()) {
    $criteriaList[] = $row;
}

$contestantQuery = "SELECT contestantID, name FROM contestant WHERE category_ID = ?";
$stmt2 = $conn->prepare($contestantQuery);
$stmt2->bind_param("i", $categoryID);
$stmt2->execute();
$contestantsResult = $stmt2->get_result();

$scoreCheckQuery = "SELECT COUNT(*) as total FROM scores WHERE judge_ID = ? AND contestant_ID = ?";
$stmt3 = $conn->prepare($scoreCheckQuery);
$stmt3->bind_param("ii", $judgeID, $contestant['contestantID']);
$stmt3->execute();
$scoreResult = $stmt3->get_result();
$scoreData = $scoreResult->fetch_assoc();
$hasScored = $scoreData['total'] > 0;

?>
<div class="p-4">
    <h3>Class Dance Competition Sheet</h3>
    <div class="">
        <table class="table table-striped border">
            <thead class="text-center">
                <tr>
                    <th scope="col">Contestant</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php while ($contestant = $contestantsResult->fetch_assoc()): ?>
                    <?php
                    // Score check for this contestant and this judge
                    $scoreCheckQuery = "SELECT COUNT(*) as total FROM scores WHERE judge_ID = ? AND contestant_ID = ?";
                    $stmt3 = $conn->prepare($scoreCheckQuery);
                    $stmt3->bind_param("ii", $judgeID, $contestant['contestantID']);
                    $stmt3->execute();
                    $scoreResult = $stmt3->get_result();
                    $scoreData = $scoreResult->fetch_assoc();
                    $hasScored = $scoreData['total'] > 0;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($contestant['name']) ?></td>
                        <td><?= $hasScored ? 'Completed' : 'Pending' ?></td>
                        <td class="action">
                            <?php if (!$hasScored): ?>
                                <span role="button" href="" data-bs-toggle="modal" data-bs-target="#sheet" data-contestant-id="<?= $contestant['contestantID'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                    </svg>
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>


            </tbody>
        </table>
    </div>
</div>



<div class="modal fade" id="sheet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tabulation Sheet</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="../../Backend/add-score.php" class="d-flex flex-column gap-3">
                    <input type="hidden" name="contestant_id" id="contestant_id">

                    <?php foreach ($criteriaList as $crit): ?>
                        <div class="d-flex gap-2 w-100 flex-column">
                            <label for=""><?= htmlspecialchars($crit['name']) . ' - ' . $crit['weight'] . '%' ?></label>
                            <input type="number"
                                class="ps-2 w-100 form-control"
                                name="criteria[<?= $crit['criteriaID'] ?>]"
                                placeholder="<?= htmlspecialchars($crit['name']) ?>"
                                min="0" max="100"
                                required>
                        </div>
                    <?php endforeach; ?>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>

            </div>
            
        </div>
    </div>
</div>

<script>
    const sheetModal = document.getElementById('sheet');
    sheetModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const contestantId = button.getAttribute('data-contestant-id');
        const input = sheetModal.querySelector('#contestant_id');
        input.value = contestantId;
    });
</script>

<?php include '../Include/Footer.php' ?>