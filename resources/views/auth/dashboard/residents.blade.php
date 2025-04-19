<script src="{{ asset('js/resident.js') }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

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
            <i class="bi bi-person-plus-fill me-2"></i> New Resident
        </button>
    </div>

    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-bordered table-hover">
        <thead class="table-success sticky-top">
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
            <tr class="clickable-row" data-resident-id="{{ $resident->id }}">
            <td>{{ $resident->id }}</td>
                <td><strong>{{ $resident->full_name }}</strong></td>
                <td>{{ $resident->gender }}</td>
                <td>{{ date('Y-m-d', strtotime($resident->birthdate)) }}</td>  
                  <td>Household #{{ $resident->household_id }}</td>
                <td>{{ $resident->income_source }}</td>
                <td>{{ $resident->contact }}</td>
                <td>
                    <button class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></button>
                    <button type="button" class="btn btn-sm btn-danger delete-resident" data-id="{{ $resident->id }}">
    <i class="bi bi-trash-fill"></i>
</button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

   <!-- Resident Details Modal - Improved Version -->
<div class="modal fade" id="residentDetailsModal" tabindex="-1" aria-labelledby="residentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="residentDetailsModalLabel">
                    <i class="bi bi-person-badge me-2"></i> Resident & Household Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Resident Information Column -->
                    <div class="col-lg-5">
                        <div class="card h-100">
                            <div class="card-header bg-light">
                                <h5 class="m-0">
                                    <i class="bi bi-person-circle me-2"></i> Resident Profile
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label text-muted small mb-1">Full Name</label>
                                    <div class="fs-5 fw-bold" id="detail-name">Loading...</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-1">Gender</label>
                                        <div id="detail-gender">Loading...</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-1">Birthdate</label>
                                        <div id="detail-birthdate">Loading...</div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small mb-1">Contact</label>
                                    <div id="detail-contact">Loading...</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small mb-1">Income Source</label>
                                    <div id="detail-income">Loading...</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Household Information Column -->
                    <div class="col-lg-7">
                        <div class="card h-100">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="m-0">
                                    <i class="bi bi-house-door me-2"></i> Household Information
                                </h5>
                                <button class="btn btn-sm btn-success" id="addMemberBtn">
                                    <i class="bi bi-person-plus me-1"></i> Add Member
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-1">Household ID</label>
                                        <div id="detail-household-id">Loading...</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small mb-1">Household Head</label>
                                        <div id="detail-head">Loading...</div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small mb-1">Address</label>
                                    <div id="detail-address">Loading...</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted small mb-1">Household Members (<span id="member-count">0</span>)</label>
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
                                                    <td colspan="4" class="text-center">Loading members...</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Close
                </button>
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

<script>
    
    document.addEventListener("DOMContentLoaded", function () {
        bindDeleteButtons();
    document.querySelectorAll(".delete-resident").forEach(button => {
        button.addEventListener("click", function (e) {
            e.stopPropagation(); // 🔒 Prevent triggering the row click event
            const residentId = this.getAttribute("data-id");

            if (confirm("Are you sure you want to delete this resident?")) {
                fetch(`/residents/${residentId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Resident deleted successfully!");
                        location.reload(); // optional: you can also just remove the row from DOM
                    } else {
                        alert("Failed to delete resident.");
                    }
                });
            }
        });
    });
});


    // Handle resident form submission
    document.getElementById("residentForm").addEventListener("submit", async function (e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Saving...';
        submitBtn.disabled = true;

        try {
            const formData = {
                full_name: document.getElementById("fullName").value,
                gender: document.getElementById("gender").value,
                birthdate: document.getElementById("birthdate").value,
                household_id: document.getElementById("household").value,
                relationship: document.getElementById("relationship").value,
                income_source: document.getElementById("income").value,
                contact: document.getElementById("contact").value,
                _token: document.querySelector('meta[name="csrf-token"]').content
            };

            const response = await fetch('/residents', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': formData._token
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Failed to save resident');
            }

            // Format birthdate to YYYY-MM-DD only
            const formattedBirthdate = data.birthdate.split('T')[0];

       // Add the new resident to the table
const newRow = `
    <tr class="clickable-row" data-resident-id="${data.id}">
        <td>${data.id}</td>
        <td><strong>${data.full_name}</strong></td>
        <td>${data.gender}</td>
        <td>${formattedBirthdate}</td>
        <td>Household #${data.household_id}</td>
        <td>${data.income_source || '-'}</td>
        <td>${data.contact || '-'}</td>
        <td>
            <button class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></button>
            <button class="btn btn-sm btn-danger delete-resident" data-id="${data.id}"><i class="bi bi-trash-fill"></i></button>
        </td>
    </tr>
`;

            
            document.querySelector("table tbody").insertAdjacentHTML('afterbegin', newRow);

            // Close the modal and reset form
            bootstrap.Modal.getInstance(document.getElementById("addResidentModal")).hide();
            this.reset();
            
            // Remove modal backdrop if it remains
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();

            showAlert('Resident added successfully!', 'success');
            
        } catch (error) {
            console.error('Error:', error);
            showAlert(error.message || 'Error saving resident', 'danger');
        } finally {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        }
    });

    document.querySelectorAll(".clickable-row").forEach(row => {
    row.addEventListener("click", function (e) {
        // Ignore clicks inside buttons
        if (e.target.closest(".btn")) return;

        const residentId = this.getAttribute("data-resident-id");

        // Load and show resident details via AJAX
        loadResidentDetails(residentId);

        // Manually trigger the modal
        const modal = new bootstrap.Modal(document.getElementById("residentDetailsModal"));
        modal.show();
    });
});


        // Add Member button click handler
        document.getElementById('addMemberBtn')?.addEventListener('click', function() {
            const householdId = document.getElementById('detail-household-id')?.textContent;
            if (householdId) {
                const householdSelect = document.getElementById('household');
                householdSelect.value = householdId;
                householdSelect.disabled = true;
                
                const detailsModal = bootstrap.Modal.getInstance(document.getElementById('residentDetailsModal'));
                detailsModal.hide();
                
                const addModal = new bootstrap.Modal(document.getElementById('addResidentModal'));
                addModal.show();
            } else {
                showAlert('Please select a household first', 'warning');
            }
        });

    // Function to load actual resident details
    async function loadResidentDetails(residentId) {
        console.log('Fetching resident:', residentId); // Debug log
        
        // Show loading state
        document.getElementById('detail-name').textContent = 'Loading...';
        document.getElementById('detail-gender').textContent = 'Loading...';
        document.getElementById('detail-birthdate').textContent = 'Loading...';
        document.getElementById('detail-contact').textContent = 'Loading...';
        document.getElementById('detail-income').textContent = 'Loading...';
        document.getElementById('detail-household-id').textContent = 'Loading...';
        document.getElementById('detail-address').textContent = 'Loading...';
        document.getElementById('detail-head').textContent = 'Loading...';
        document.getElementById('member-count').textContent = '0';
        document.getElementById('detail-members').innerHTML = '<tr><td colspan="4" class="text-center">Loading members...</td></tr>';

        try {
            const response = await fetch(`/residents/${residentId}`);
            console.log('Response status:', response.status); // Debug log
            
            if (!response.ok) {
                throw new Error('Failed to fetch resident data');
            }

            const residentData = await response.json();
            console.log('Received data:', residentData); // Debug log

            // Format birthdate to remove time portion
            const formattedBirthdate = residentData.birthdate.split('T')[0];

            // Update resident info
            document.getElementById('detail-name').textContent = residentData.full_name;
            document.getElementById('detail-gender').textContent = residentData.gender;
            document.getElementById('detail-birthdate').textContent = formattedBirthdate;
            document.getElementById('detail-contact').textContent = residentData.contact || '-';
            document.getElementById('detail-income').textContent = residentData.income_source || '-';
            
            // Update household info if available
            if (residentData.household) {
                document.getElementById('detail-household-id').textContent = residentData.household.id;
                document.getElementById('detail-address').textContent = 
                    `${residentData.household.purok || ''}, ${residentData.household.barangay || ''}, ${residentData.household.city || ''}`.replace(/^, /, '');
                document.getElementById('detail-head').textContent = residentData.household.head_name || '-';
                
                // Update members table
                const membersTable = document.getElementById('detail-members');
                membersTable.innerHTML = '';
                
                if (residentData.household.members && residentData.household.members.length > 0) {
                    residentData.household.members.forEach(member => {
                        const row = document.createElement('tr');
                        if (member.id == residentId) {
                            row.classList.add('table-active');
                        }
                        
                        let badgeClass = 'bg-secondary';
                        if (member.relationship === 'Head') badgeClass = 'bg-primary';
                        else if (member.relationship === 'Spouse') badgeClass = 'bg-info';
                        
                        row.innerHTML = `
                            <td>${member.full_name}</td>
                            <td><span class="badge ${badgeClass}">${member.relationship}</span></td>
                            <td>${member.age || '-'}</td>
                            <td><span class="badge bg-success">Active</span></td>
                        `;
                        membersTable.appendChild(row);
                    });
                    document.getElementById('member-count').textContent = residentData.household.members.length;
                } else {
                    membersTable.innerHTML = '<tr><td colspan="4" class="text-center">No members found</td></tr>';
                }
            }
        } catch (error) {
            console.error('Error loading resident details:', error);
            showAlert('Failed to load resident details', 'danger');
            
            document.getElementById('detail-name').textContent = 'Error loading data';
            document.getElementById('detail-members').innerHTML = '<tr><td colspan="4" class="text-center text-danger">Failed to load members</td></tr>';
        }
    }

    // Helper function to show alerts
    function showAlert(message, type) {
        const existingAlert = document.querySelector('.alert');
        if (existingAlert) existingAlert.remove();

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
        alertDiv.style.zIndex = '1060';
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
</script>