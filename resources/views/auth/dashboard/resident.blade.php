<div class="container mt-4">
    <h2 class="mb-4">Resident Information</h2>

<!-- Search and Add Button -->
<!-- Search and Add Button -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <!-- Search Section -->
    <div class="d-flex align-items-center" style="flex: 1; max-width: 300px;">
        <input class="form-control" type="search" placeholder="Search" aria-label="Search" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
        <button class="btn btn-primary" type="submit" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
            <i class="bi bi-search"></i>
        </button>
    </div>

    <!-- Add Resident Button -->
    <button class="btn btn-success d-flex align-items-center">
        <i class="bi bi-person-plus-fill me-2"></i> Add Resident
    </button>
</div>



    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Gender</th>
                    <th>Birthdate</th>
                    <th>Source of Income</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sample Row -->
                <tr>
                    <td>1</td>
                    <td>Juan Dela Cruz</td>
                    <td>Male</td>
                    <td>1990-01-15</td>
                    <td>Business</td>
                    <td>Purok 1, Barangay Malinis</td>
                    <td>09123456789</td>
                    <td>
                        <button class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                    </td>
                </tr>
                <!-- Add more rows dynamically here -->
            </tbody>
        </table>
    </div>
</div>
