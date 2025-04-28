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
                  <!-- Inside the residentDetailsModal - Household Information Column -->
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
                    <div id="detail-household-head" class="fw-bold">
                        <!-- This will show either the head's name or "Not Specified" -->
                        Loading...
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-muted small mb-1">Address</label>
                <div id="detail-address">Loading...</div>
            </div>
            
            <!-- Rest of your household members table remains the same -->
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
<!-- Inside the "Household Information" section (Right Column) -->
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
        <label for="household_head_name" class="form-label">Household Head Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="household_head_name" required placeholder="Enter household head's full name">
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
    document.querySelectorAll(".delete-resident").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.stopPropagation();
            const residentId = this.getAttribute("data-id");

            if (confirm("Are you sure you want to delete this resident?")) {
                fetch(`/residents/${residentId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                })
                    .then((res) => res.json())
                    .then((data) => {
                        if (data.success) {
                            alert("Resident deleted successfully!");
                            location.reload();
                        } else {
                            alert("Failed to delete resident.");
                        }
                    });
            }
        });
    });
});

// Handle resident form submission
document
    .getElementById("residentForm")
    .addEventListener("submit", async function (e) {
        e.preventDefault();

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML =
            '<i class="bi bi-arrow-repeat spinner"></i> Saving...';
        submitBtn.disabled = true;

        try {
            const formData = {
                full_name: document.getElementById("fullName").value,
                gender: document.getElementById("gender").value,
                birthdate: document.getElementById("birthdate").value,
                household_id: document.getElementById("household").value,
                household_head_name: document.getElementById(
                    "household_head_name"
                ).value,
                relationship: document.getElementById("relationship").value,
                income_source: document.getElementById("income").value,
                contact: document.getElementById("contact").value,
                _token: document.querySelector('meta[name="csrf-token"]')
                    .content,
            };

            const response = await fetch("/residents", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": formData._token,
                },
                body: JSON.stringify(formData),
            });

            const result = await response.json();
            console.log("API Response:", result); // Debugging

            if (!response.ok) {
                throw new Error(result.message || "Failed to save resident");
            }

            // Handle both response formats
            const residentData = result.resident || result;

            // Format all data with proper fallbacks
            const formattedData = {
                id: residentData.id || "",
                full_name: residentData.full_name || "N/A",
                gender: residentData.gender || "N/A",
                birthdate: residentData.birthdate
                    ? residentData.birthdate.split("T")[0] ||
                      residentData.birthdate
                    : "N/A",
                household_id:
                    residentData.household_id ||
                    residentData.household?.id ||
                    "N/A",
                income_source: residentData.income_source || "-",
                contact: residentData.contact || "-",
            };

            // Create new row
            const newRow = `
        <tr class="clickable-row" data-resident-id="${formattedData.id}">
            <td>${formattedData.id}</td>
            <td><strong>${formattedData.full_name}</strong></td>
            <td>${formattedData.gender}</td>
            <td>${formattedData.birthdate}</td>
            <td>Household #${formattedData.household_id}</td>
            <td>${formattedData.income_source}</td>
            <td>${formattedData.contact}</td>
            <td>
                <button class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger delete-resident" data-id="${formattedData.id}">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </td>
        </tr>`;

            // Insert new row
            const tbody = document.querySelector("table tbody");
            if (!tbody) throw new Error("Table body not found");
            tbody.insertAdjacentHTML("afterbegin", newRow);

            // Close modal and cleanup
            bootstrap.Modal.getInstance(
                document.getElementById("addResidentModal")
            ).hide();
            this.reset();
            document.body.classList.remove("modal-open");
            const backdrop = document.querySelector(".modal-backdrop");
            if (backdrop) backdrop.remove();

            showAlert("Resident added successfully!", "success");
        } catch (error) {
            console.error("Error:", error);
            showAlert(error.message || "Error saving resident", "danger");
        } finally {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        }
    });

// Row click handler
// Replace your existing row click handler with this improved version
document.addEventListener("click", function (e) {
    // Handle clickable rows (using event delegation for dynamically added rows)
    const row = e.target.closest(".clickable-row");
    if (row && !e.target.closest(".btn")) {
        const residentId = row.getAttribute("data-resident-id");
        loadResidentDetails(residentId);
        new bootstrap.Modal(
            document.getElementById("residentDetailsModal")
        ).show();
    }

    // Handle delete buttons (already properly implemented in your code)
});

// Household change handler
document.getElementById("household").addEventListener("change", function () {
    const householdId = this.value;
    const householdHeadSelect = document.getElementById("household_head");
    householdHeadSelect.innerHTML =
        '<option value="" disabled selected>Select Head</option>';

    if (!householdId) return;

    fetch(`/households/${householdId}/heads`)
        .then((response) => response.json())
        .then((data) => {
            data.forEach((head) => {
                const option = document.createElement("option");
                option.value = head.id;
                option.textContent = head.full_name;
                householdHeadSelect.appendChild(option);
            });
        })
        .catch((error) => {
            console.error("Error fetching household heads:", error);
        });
});

// Add Member button handler
document.getElementById("addMemberBtn")?.addEventListener("click", function () {
    const householdId = document.getElementById(
        "detail-household-id"
    )?.textContent;
    if (householdId) {
        const householdSelect = document.getElementById("household");
        householdSelect.value = householdId;
        householdSelect.disabled = true;
        bootstrap.Modal.getInstance(
            document.getElementById("residentDetailsModal")
        ).hide();
        new bootstrap.Modal(document.getElementById("addResidentModal")).show();
    } else {
        showAlert("Please select a household first", "warning");
    }
});

// Load resident details
async function loadResidentDetails(residentId) {
    // Set all fields to loading state
    const detailFields = [
        "name",
        "gender",
        "birthdate",
        "contact",
        "income",
        "household-id",
        "address",
        "household-head",
        "members",
    ];

    detailFields.forEach((field) => {
        const el = document.getElementById(`detail-${field}`);
        if (el) el.textContent = "Loading...";
    });

    try {
        // First check if we're using /api/ or /residents/ endpoint
        const endpoint = `/api/residents/${residentId}`;
        const response = await fetch(endpoint);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log("API Response:", data); // Debugging

        // Resident Info
        document.getElementById("detail-name").textContent =
            data.full_name || "N/A";
        document.getElementById("detail-gender").textContent =
            data.gender || "N/A";
        document.getElementById("detail-birthdate").textContent = data.birthdate
            ? new Date(data.birthdate).toLocaleDateString()
            : "N/A";
        document.getElementById("detail-contact").textContent =
            data.contact || "-";
        document.getElementById("detail-income").textContent =
            data.income_source || "-";

        // Household Info
        const membersContainer = document.getElementById("detail-members");
        if (data.household) {
            document.getElementById("detail-household-id").textContent =
                data.household.id || "N/A";
            document.getElementById("detail-household-head").textContent =
                data.household.head_name || "Not Specified";

            // Address
            const addressParts = [
                data.household.purok,
                data.household.barangay,
                data.household.city,
            ].filter((part) => part && part.trim() !== "");
            document.getElementById("detail-address").textContent =
                addressParts.join(", ") || "Address not specified";

            // Members list
            if (data.household.members && data.household.members.length) {
                membersContainer.innerHTML = data.household.members
                    .map(
                        (member) => `
                    <tr>
                        <td>${member.full_name || "N/A"}</td>
                        <td>${member.relationship || "N/A"}</td>
                        <td>${member.age || "N/A"}</td>
                        <td>${member.status || "N/A"}</td>
                    </tr>
                `
                    )
                    .join("");

                // Update member count
                document.getElementById("member-count").textContent =
                    data.household.members.length;
            } else {
                membersContainer.innerHTML =
                    '<tr><td colspan="4" class="text-center">No members found</td></tr>';
                document.getElementById("member-count").textContent = "0";
            }
        } else {
            document.getElementById("detail-household-id").textContent = "N/A";
            document.getElementById("detail-household-head").textContent =
                "Not Specified";
            document.getElementById("detail-address").textContent =
                "Not Available";
            membersContainer.innerHTML =
                '<tr><td colspan="4" class="text-center">No household information</td></tr>';
            document.getElementById("member-count").textContent = "0";
        }
    } catch (error) {
        console.error("Error loading resident:", error);
        document.getElementById("detail-name").textContent =
            "Error loading data";
        showAlert("Failed to load resident details", "danger");
    }
}

// Alert helper function
function showAlert(message, type) {
    const existingAlert = document.querySelector(".alert");
    if (existingAlert) existingAlert.remove();

    const alertDiv = document.createElement("div");
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    alertDiv.style.zIndex = "1060";
    alertDiv.role = "alert";
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 5000);
}

</script>