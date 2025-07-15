<?php include '../Include/Header.php';

$categoryQuery = "SELECT * FROM category";
$categoryResult = $conn->query($categoryQuery);
$categories = [];

while ($row = $categoryResult->fetch_assoc()) {
    $categories[] = $row;
}

$sql = "SELECT c.contestantID, c.name AS contestant_name, c.category_ID AS category_id, cat.name AS category_name FROM contestant c JOIN category cat ON c.category_ID = cat.catergoryID";
$result = $conn->query($sql);

?>

<div class="p-4">
    <div class="d-flex justify-content-between mb-2">
        <h3>Contestants</h3>
        <button class="py-1 px-3 border bg-primary text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New</button>
    </div>
    <div class="">
        <table class="table table-striped border">
            <thead class="text-center">
                <tr>
                    <th scope="col">Contestant ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">

                <?php if ($result->num_rows > 0):
                    $count = 1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['contestantID']) ?></td>
                            <td><?= htmlspecialchars($row['contestant_name']) ?></td>
                            <td><?= htmlspecialchars($row['category_name']) ?></td>
                            <td>
                                <button
                                    class="btn btn-sm btn-edit-contestant"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editContestant"
                                    data-contestantid="<?= htmlspecialchars($row['contestantID']) ?>"
                                    data-contestantname="<?= htmlspecialchars($row['contestant_name']) ?>"
                                    data-categoryid="<?= htmlspecialchars($row['category_id']) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-pencil me-2" viewBox="0 0 16 16" role="button">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                    </svg>
                                </button>
                                <a href="../../Backend/delete-contestant.php?id=<?= $row['contestantID'] ?>" onclick="return confirm('Are you sure?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3" viewBox="0 0 16 16" role="button">
                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No contestant found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../Backend/add-contestant.php" method="POST" class="d-flex flex-column gap-3">
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Contestant Name</label>
                        <input type="text" placeholder="Contestant Name" class="ps-2 w-100 form-control" name="name">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Category</label>
                        <select class="form-select" aria-label="Default select example" name="category" required>
                            <option selected disabled>-- Please Select Category --</option>
                            <?php foreach ($categories as $row): ?>
                                <option value="<?= $row['catergoryID']; ?>"><?= htmlspecialchars($row['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editContestant" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../Backend/update-contestant.php" method="POST" class="d-flex flex-column gap-3">
                    <input type="text" name="contestantID" hidden>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Contestant Name</label>
                        <input type="text" placeholder="Contestant Name" class="ps-2 w-100 form-control" name="name">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Category</label>
                        <select class="form-select" aria-label="Default select example" name="category" required>
                            <option selected disabled>-- Please Select Category --</option>
                            <?php foreach ($categories as $row): ?>
                                <option value="<?= $row['catergoryID']; ?>"><?= htmlspecialchars($row['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editButtons = document.querySelectorAll('.btn-edit-contestant');
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.getElementById('editContestant');

                modal.querySelector('input[name="contestantID"]').value = button.getAttribute('data-contestantID');
                modal.querySelector('input[name="name"]').value = button.getAttribute('data-contestantName');
                modal.querySelector('select[name="category"]').value = button.getAttribute('data-categoryid');
            });
        });
    });
</script>


<?php include '../Include/Footer.php' ?>