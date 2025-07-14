<?php include '../Include/Header.php' ?>
<div class="p-4">
    <h3>Dance Battle Sheet</h3>
    <div class="">
        <table class="table table-striped border">
            <thead class="text-center">
                <tr>
                    <th scope="col">Candidate</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td>Grade 7</td>
                    <td>Pending</td>
                    <td class="action">
                        <span role="button" data-bs-toggle="modal" data-bs-target="#sheet">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Grade 8</td>
                    <td>Pending</td>
                    <td class="action">
                        <span role="button" data-bs-toggle="modal" data-bs-target="#sheet">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg>
                        </span>
                    </td>
                </tr>

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
                <form action="" class="d-flex flex-column gap-3">
                    <input type="text" class="ps-2 w-100 form-control" hidden value="1" name="group_id">

                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Group Name</label>
                        <input type="text" placeholder="Group Name" value="Grade 7" class="ps-2 w-100 form-control" disabled>
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Battle Mentality & Strategy - 35%</label>
                        <input type="number" placeholder="Battle Mentality & Strategy" class="ps-2 w-100 form-control">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Freestyle Creativity - 30%</label>
                        <input type="number" placeholder="Freestyle Creativity" class="ps-2 w-100 form-control">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Stage Presence & Impact - 25%</label>
                        <input type="number" placeholder="Stage Presence & Impact" class="ps-2 w-100 form-control">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Control & Execution - 10%</label>
                        <input type="number" placeholder="Control & Execution" class="ps-2 w-100 form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<?php include '../Include/Footer.php' ?>