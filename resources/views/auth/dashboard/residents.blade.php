<script src="{{ asset('js/resident.js') }}"></script>

<div class="container mt-4">
    <h2 class="mb-4">Resident Information</h2>

    <!-- Search and Add Button Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <!-- Search Section -->
        <div class="d-flex align-items-center" style="flex: 1; max-width: 300px;">
            <input class="form-control" type="search" placeholder="Search residents..." aria-label="Search" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
            <button class="btn btn-primary" type="submit" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                <i class="bi bi-search"></i>
            </button>
        </div>

        <!-- Add Resident Button -->
        <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addResidentModal">
            <i class="bi bi-person-plus-fill me-2"></i> Add Resident
        </button>
    </div>

    <!-- Table Section -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Gender</th>
                    <th>Birthdate</th>
                    <th>Household</th>
                    <th>Source of Income</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
@foreach ($residents as $resident)
<tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#residentDetailsModal" data-resident-id="{{ $resident->id }}">
    <td>{{ $resident->id }}</td>
    <td><strong>{{ $resident->full_name }}</strong></td>
    <td>{{ $resident->gender }}</td>
    <td>{{ $resident->birthdate }}</td>
    <td>{{ $resident->household }}</td>
    <td>{{ $resident->income_source }}</td>
    <td>{{ $resident->contact }}</td>
    <td>
        <button class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></button>
        <button class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
    </td>
</tr>
@endforeach
</tbody>

        </table>
    </div>

   <!-- Resident Details Modal - Landscape Version -->
<div class="modal fade" id="residentDetailsModal" tabindex="-1" aria-labelledby="residentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="residentDetailsModalLabel">
                    <i class="bi bi-person-badge me-2"></i> Resident & Household Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Resident Information Column -->
                    <div class="col-lg-5 border-end">
                        <div class="d-flex align-items-center mb-4">
                            <h5 class="m-0">
                                <i class="bi bi-person-circle me-2"></i>Resident Profile
                            </h5>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Full Name:</div>
                            <div class="col-sm-8" id="detail-name">Juan Dela Cruz</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Gender:</div>
                            <div class="col-sm-8" id="detail-gender">Male</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Birthdate:</div>
                            <div class="col-sm-8" id="detail-birthdate">January 15, 1990 (Age 33)</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Contact:</div>
                            <div class="col-sm-8" id="detail-contact">0912 345 6789</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Income Source:</div>
                            <div class="col-sm-8" id="detail-income">Business Owner</div>
                        </div>
                    </div>

                    <!-- Household Information Column -->
                    <div class="col-lg-7 ps-4">
                        <div class="d-flex align-items-center mb-4">
                            <h5 class="m-0">
                                <i class="bi bi-house-door me-2"></i>Household Information
                            </h5>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Household ID:</div>
                            <div class="col-sm-8" id="detail-household-id">#1</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Address:</div>
                            <div class="col-sm-8" id="detail-address">
                                Purok 1, Barangay Malinis<br>
                                City of San Fernando, Pampanga
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Household Head:</div>
                            <div class="col-sm-8" id="detail-head">Juan Dela Cruz</div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="fw-bold mb-2">Household Members (4):</div>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Relationship</th>
                                            <th>Age</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail-members">
                                        <tr>
                                            <td>Juan Dela Cruz</td>
                                            <td><span class="badge bg-primary">Head</span></td>
                                            <td>33</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td>Maria Dela Cruz</td>
                                            <td><span class="badge bg-info">Spouse</span></td>
                                            <td>31</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td>Pedro Dela Cruz</td>
                                            <td><span class="badge bg-warning text-dark">Child</span></td>
                                            <td>10</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                        </tr>
                                        <tr>
                                            <td>Juanita Dela Cruz</td>
                                            <td><span class="badge bg-secondary">Mother</span></td>
                                            <td>68</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Close
              
            </div>
        </div>
    </div>
</div>

   <!-- Add Resident Modal (Landscape) -->
<div class="modal fade" id="addResidentModal" tabindex="-1" aria-labelledby="addResidentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="residentForm">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addResidentModalLabel">
                        <i class="bi bi-person-plus-fill me-2"></i> Add New Resident
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Personal Information</h6>
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fullName" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-select" id="gender" required>
                                        <option value="" disabled selected>Select</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="birthdate" class="form-label">Birthdate <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="birthdate" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contact" placeholder="09123456789">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Household Information</h6>
                            <div class="mb-3">
                                <label for="household" class="form-label">Household <span class="text-danger">*</span></label>
                                <select class="form-select" id="household" required>
                                    <option value="" disabled selected>Select Household</option>
                                    <option value="1">Household #1 - Purok 1</option>
                                    <option value="2">Household #2 - Purok 2</option>
                                    <option value="3">Household #3 - Purok 3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="relationship" class="form-label">Relationship to Head <span class="text-danger">*</span></label>
                                <select class="form-select" id="relationship" required>
                                    <option value="" disabled selected>Select relationship</option>
                                    <option>Head</option>
                                    <option>Spouse</option>
                                    <option>Child</option>
                                    <option>Parent</option>
                                    <option>Sibling</option>
                                    <option>Other Relative</option>
                                    <option>Non-relative</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="income" class="form-label">Source of Income</label>
                                <input type="text" class="form-control" id="income" placeholder="Occupation or income source">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save-fill me-1"></i> Save Resident
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>