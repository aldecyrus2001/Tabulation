<?php include '../Include/Header.php' ?>
<div class="p-4">
    <div class="d-flex justify-content-between mb-2">
        <h3>Criteria</h3>
        <button class="py-1 px-3 border bg-primary text-white" data-bs-toggle="modal" data-bs-target="#AddCategory">Add New</button>
    </div>
    <div class="">
        <table class="table table-striped border">
            <thead class="text-center">
                <tr>
                    <th scope="col">Category</th>
                    <th scope="col">Criteria</th>
                    <th scope="col">Percentage</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td>Class Dance Competition</td>
                    <td>Choreography & Creativity</td>
                    <td>35</td>
                    <td class="action">

                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16" role="button">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg>
                    </td>
                </tr>
                <tr>
                    <td>Class Dance Competition</td>
                    <td>Execution & Synchronization</td>
                    <td>30</td>
                    <td class="action">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16" role="button">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="AddCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="d-flex flex-column gap-3">
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Category</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected disabled>-- Please Select Category --</option>
                            <option value="1">Class Dance Competition</option>
                            <option value="2">Dance Battle</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Category Name</label>
                        <input type="text" placeholder="Category Name" class="ps-2 w-100 form-control">
                    </div>
                    <div class="d-flex gap-2 w-100 flex-column">
                        <label for="">Weight</label>
                        <input type="number" placeholder="Weight" class="ps-2 w-100 form-control">
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