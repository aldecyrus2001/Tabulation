<?php include '../Include/Header.php';

$sql = "SELECT * FROM `user` WHERE `role` = 'user'";
$result = $conn->query($sql);

?>

<div class="p-4">
    <div class="d-flex justify-content-between mb-2">
        <h3>Judges</h3>
        <button class="py-1 px-3 border bg-primary text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New</button>
    </div>
    <div class="">
        <table class="table table-striped border">
            <thead class="text-center">
                <tr>
                    <th scope="col">Judge ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Middle Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">

                <?php if ($result->num_rows > 0):
                    $count = 1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td><?= htmlspecialchars($row['firstname']) ?></td>
                            <td><?= htmlspecialchars($row['middlename']) ?></td>
                            <td><?= htmlspecialchars($row['lastname']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-view-judge" data-bs-toggle="modal" data-bs-target="#viewModal" data-firstname="<?= htmlspecialchars($row['firstname'], ENT_QUOTES) ?>" data-middlename="<?= htmlspecialchars($row['middlename'], ENT_QUOTES) ?>" data-lastname="<?= htmlspecialchars($row['lastname'], ENT_QUOTES) ?>" data-username="<?= htmlspecialchars($row['username'], ENT_QUOTES) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-eye me-2" viewBox="0 0 16 16" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                    </svg>
                                </button>
                                <button class="btn btn-sm btn-edit-judge" data-bs-toggle="modal" data-bs-target="#editModal" data-userID="<?= htmlspecialchars($row['userID'], ENT_QUOTES) ?>" data-firstname="<?= htmlspecialchars($row['firstname'], ENT_QUOTES) ?>" data-middlename="<?= htmlspecialchars($row['middlename'], ENT_QUOTES) ?>" data-lastname="<?= htmlspecialchars($row['lastname'], ENT_QUOTES) ?>" data-username="<?= htmlspecialchars($row['username'], ENT_QUOTES) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-pencil me-2" viewBox="0 0 16 16" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Update">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                    </svg>
                                </button>
                                <a href="../../Backend/delete-judge.php?id=<?= $row['userID'] ?>" onclick="return confirm('Are you sure you?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3" viewBox="0 0 16 16" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No judges found.</td>
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
                <form action="../../Backend/add-judges.php" method="POST" class="d-flex flex-column gap-3">
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Firstname</label>
                        <input type="text" placeholder="Firstname" class="ps-2 w-100 form-control" name="firstname">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Middlename</label>
                        <input type="text" placeholder="Middlename" class="ps-2 w-100 form-control" name="middlename">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Lastname</label>
                        <input type="text" placeholder="Lastname" class="ps-2 w-100 form-control" name="lastname">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Username</label>
                        <input type="text" placeholder="Username" class="ps-2 w-100 form-control" name="username">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Password</label>
                        <input type="password" placeholder="Password" class="ps-2 w-100 form-control" name="password">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Confirm Password</label>
                        <input type="password" placeholder="Confirm Password" class="ps-2 w-100 form-control" name="confirmpassword">
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

<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">View Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../Backend/add-judges.php" method="POST" class="d-flex flex-column gap-3">
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Firstname</label>
                        <input type="text" placeholder="Firstname" class="ps-2 w-100 form-control" name="firstname" disabled>
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Middlename</label>
                        <input type="text" placeholder="Middlename" class="ps-2 w-100 form-control" name="middlename" disabled>
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Lastname</label>
                        <input type="text" placeholder="Lastname" class="ps-2 w-100 form-control" name="lastname" disabled>
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Username</label>
                        <input type="text" placeholder="Username" class="ps-2 w-100 form-control" name="username" disabled>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../Backend/update-judge.php" method="POST" class="d-flex flex-column gap-3">
                    <input type="text" class="ps-2 w-100 form-control" name="userID" hidden>

                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Firstname</label>
                        <input type="text" placeholder="Firstname" class="ps-2 w-100 form-control" name="firstname">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Middlename</label>
                        <input type="text" placeholder="Middlename" class="ps-2 w-100 form-control" name="middlename">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Lastname</label>
                        <input type="text" placeholder="Lastname" class="ps-2 w-100 form-control" name="lastname">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Username</label>
                        <input type="text" placeholder="Username" class="ps-2 w-100 form-control" name="username">
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
        const viewButtons = document.querySelectorAll('.btn-view-judge');

        viewButtons.forEach(button => {
            button.addEventListener('click', () => {
                const firstname = button.getAttribute('data-firstname');
                const middlename = button.getAttribute('data-middlename');
                const lastname = button.getAttribute('data-lastname');
                const username = button.getAttribute('data-username');

                const modal = document.getElementById('viewModal');

                modal.querySelector('input[name="firstname"]').value = firstname;
                modal.querySelector('input[name="middlename"]').value = middlename;
                modal.querySelector('input[name="lastname"]').value = lastname;
                modal.querySelector('input[name="username"]').value = username;
            });
        });

        const editButtons = document.querySelectorAll('.btn-edit-judge');

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.getElementById('editModal');

                modal.querySelector('input[name="userID"]').value = button.getAttribute('data-userID');
                modal.querySelector('input[name="firstname"]').value = button.getAttribute('data-firstname');
                modal.querySelector('input[name="middlename"]').value = button.getAttribute('data-middlename');
                modal.querySelector('input[name="lastname"]').value = button.getAttribute('data-lastname');
                modal.querySelector('input[name="username"]').value = button.getAttribute('data-username');
            });
        });
    });
</script>


<?php include '../Include/Footer.php' ?>