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
                <!-- Sample Row - clickable -->
                <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#residentDetailsModal" data-resident-id="1">
                    <td>1</td>
                    <td><strong>Juan Dela Cruz</strong> <span class="badge bg-primary ms-2">Head</span></td>
                    <td>Male</td>
                    <td>1990-01-15</td>
                    <td>Household #1 - Purok 1</td>
                    <td>Business</td>
                    <td>09123456789</td>
                    <td>
                        <button class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                    </td>
                </tr>
                <!-- Second Sample Row -->
                <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#residentDetailsModal" data-resident-id="2">
                    <td>2</td>
                    <td>Maria Dela Cruz</td>
                    <td>Female</td>
                    <td>1992-05-20</td>
                    <td>Household #1 - Purok 1</td>
                    <td>Teacher</td>
                    <td>09123456788</td>
                    <td>
                        <button class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                    </td>
                </tr>
                <!-- More rows would be added dynamically -->
            </tbody>
        </table>
    </div>

    <!-- Resident Details Modal (Shows household info) -->
    <div class="modal fade" id="residentDetailsModal" tabindex="-1" aria-labelledby="residentDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="residentDetailsModalLabel">Resident & Household Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Resident Information</h5>
                            <div class="mb-3">
                                <label class="form-label"><strong>Full Name:</strong></label>
                                <p id="detail-name">Juan Dela Cruz</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Gender:</strong></label>
                                <p id="detail-gender">Male</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Birthdate:</strong></label>
                                <p id="detail-birthdate">1990-01-15</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Contact:</strong></label>
                                <p id="detail-contact">09123456789</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Household Information</h5>
                            <div class="mb-3">
                                <label class="form-label"><strong>Household ID:</strong></label>
                                <p id="detail-household-id">#1</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Address:</strong></label>
                                <p id="detail-address">Purok 1, Barangay Malinis</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Household Head:</strong></label>
                                <p id="detail-head">Juan Dela Cruz</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Members:</strong></label>
                                <ul id="detail-members" class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Juan Dela Cruz
                                        <span class="badge bg-primary">Head</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Maria Dela Cruz
                                        <span class="badge bg-secondary">Spouse</span>
                                    </li>
                                    <!-- More members would be added dynamically -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Resident Modal -->
    <div class="modal fade" id="addResidentModal" tabindex="-1" aria-labelledby="addResidentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="residentForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addResidentModalLabel">Add Resident</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" required>
                                <option value="" disabled selected>Select</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate" required>
                        </div>
                        <div class="mb-3">
                            <label for="household" class="form-label">Household</label>
                            <select class="form-control" id="household" required>
                                <option value="" disabled selected>Select Household</option>
                                <option value="1">Household #1 - Purok 1</option>
                                <option value="2">Household #2 - Purok 2</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="relationship" class="form-label">Relationship to Head</label>
                            <select class="form-control" id="relationship" required>
                                <option value="" disabled selected>Select</option>
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
                            <input type="text" class="form-control" id="income">
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Resident</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Script -->
    <script>
        // Handle resident form submission
        document.getElementById("residentForm").addEventListener("submit", function (e) {
            e.preventDefault();

            // Get form values
            const fullName = document.getElementById("fullName").value;
            const gender = document.getElementById("gender").value;
            const birthdate = document.getElementById("birthdate").value;
            const household = document.getElementById("household").value;
            const relationship = document.getElementById("relationship").value;
            const income = document.getElementById("income").value;
            const contact = document.getElementById("contact").value;

            // Get table and insert new row
            const table = document.querySelector("table tbody");
            const newRow = document.createElement("tr");
            newRow.className = "clickable-row";
            newRow.setAttribute("data-bs-toggle", "modal");
            newRow.setAttribute("data-bs-target", "#residentDetailsModal");
            newRow.setAttribute("data-resident-id", table.rows.length + 1);

            const rowCount = table.rows.length + 1;

            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td>${fullName} ${relationship === 'Head' ? '<span class="badge bg-primary ms-2">Head</span>' : ''}</td>
                <td>${gender}</td>
                <td>${birthdate}</td>
                <td>Household #${household} - Purok ${household}</td>
                <td>${income}</td>
                <td>${contact}</td>
                <td>
                    <button class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                </td>
            `;

            table.appendChild(newRow);

            // Reset form and close modal
            document.getElementById("residentForm").reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById("addResidentModal"));
            modal.hide();
        });

        // Handle click on resident row to show details
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.clickable-row');
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    // In a real app, you would fetch this data from your database
                    // based on the resident-id data attribute
                    const residentId = this.getAttribute('data-resident-id');
                    
                    // Sample data - replace with actual data fetch
                    if (residentId === "1") {
                        document.getElementById('detail-name').textContent = 'Juan Dela Cruz';
                        document.getElementById('detail-gender').textContent = 'Male';
                        document.getElementById('detail-birthdate').textContent = '1990-01-15';
                        document.getElementById('detail-contact').textContent = '09123456789';
                        document.getElementById('detail-household-id').textContent = '#1';
                        document.getElementById('detail-address').textContent = 'Purok 1, Barangay Malinis';
                        document.getElementById('detail-head').textContent = 'Juan Dela Cruz';
                        
                        // Clear previous members
                        const membersList = document.getElementById('detail-members');
                        membersList.innerHTML = '';
                        
                        // Add members
                        const members = [
                            { name: 'Juan Dela Cruz', relation: 'Head' },
                            { name: 'Maria Dela Cruz', relation: 'Spouse' }
                        ];
                        
                        members.forEach(member => {
                            const li = document.createElement('li');
                            li.className = 'list-group-item d-flex justify-content-between align-items-center';
                            li.innerHTML = `
                                ${member.name}
                                <span class="badge ${member.relation === 'Head' ? 'bg-primary' : 'bg-secondary'}">${member.relation}</span>
                            `;
                            membersList.appendChild(li);
                        });
                    }
                });
            });
        });
    </script>
</div>