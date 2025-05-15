<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Incidents</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    /* Base body styles to prevent scrolling issues */
    html, body {
        width: 100%;
        overflow-x: hidden!important; /* Prevent horizontal scroll */
        overflow-y: hidden!important; /* Prevent horizontal scroll */
        margin: 0;
        padding: 0;
    }

    .status-badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        border-radius: 0.25rem;
    }

    /* Modal handling */
    body.modal-open {
        overflow: hidden; /* Prevent body scroll when modal is open */
        padding-right: 0 !important;
    }

    .status-pending { background-color: #cce5ff; color: #004085; }
    .status-ongoing { background-color: #fff3cd; color: #856404; }
    .status-resolved { background-color: #d4edda; color: #155724; }

    .report-btn {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    transition: all 0.2s ease;
}

    .report-btn:hover {
    background-color: #bb2d3b !important;
    border-color: #b02a37 !important;
}
.btn:not(:disabled):not(.disabled) {
    opacity: 1 !important;
}
    /* Container and table adjustments */
    .container {
        max-width: 1228px;
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    .table-responsive {
        max-height: 600px;
        overflow-y: auto;
        overflow-x: hidden; /* Hide horizontal scroll */
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }

    /* Hide scrollbar for Chrome, Safari and Opera */
    .table-responsive::-webkit-scrollbar {
        display: none;
    }

    /* Zebra striping */
    .table-striped>tbody>tr:nth-child(odd)>td {
        background-color: rgba(0,0,0,0.02);
    }

    /* Search bar styling */
    .search-container {
        display: flex;
        gap: 5px;
        margin-bottom: 20px;
        align-items: center;
        flex-wrap: wrap; /* Prevent overflow on small screens */
    }
    .search-container .form-control {
        max-width: 300px;
        height: 38px;
        flex-grow: 1; /* Allow search bar to shrink */
    }

    /* Three dots dropdown */
    .dropdown-toggle::after {
        display: none;
    }
    .action-btn {
        padding: 0.25rem 0.5rem;
    }

    /* Image preview */
    .image-preview-container {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    .image-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    /* Modal and backdrop styling */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1040;
    }
    .modal {
        z-index: 1050;
        overflow-y: auto; /* Allow scrolling inside modal if needed */
    }

    /* Button height adjustments */
    .btn-custom-height {
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }

    /* Dropdown menu styling */
    .dropdown-menu {
        min-width: 10rem;
        padding: 0.5rem 0;
        position: absolute; /* Ensure proper positioning */
      
    }
    .dropdown-item {
        padding: 0.5rem 1rem;
    }
    .dropdown {
    position: static;
}

    /* Loading backdrop */
    .custom-loading-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1050;
        display: none;
    }
    .custom-loading-backdrop.show {
        display: block;
    }

    /* Table layout fixes */
    table {
        table-layout: fixed;
        width: 100%;
    }
    th, td {
        word-wrap: break-word;
    
    }
</style>
</head>
<body class="bg-light">
    <div class="container py-4">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-0">Barangay Incidents</h1>
                <p class="text-muted mb-0">Manage and track barangay incidents</p>
            </div>
            <div class="d-flex align-items-center gap-3">  <!-- Changed to flex with gap -->
        <input type="text" id="searchInput" class="form-control" placeholder="Search..." style="width: 250px;">
        <button class="btn report-btn text-white" 
                data-bs-toggle="modal" 
                data-bs-target="#reportIncidentModal"
                style="height: 40px; white-space: nowrap;width:150px;text-align:left">
            <i class="bi bi-plus-lg me-1"></i>Report
        </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    @if(isset($incidents) && $incidents->isEmpty())
                        <div class="alert alert-info m-3">
                            <i class="bi bi-info-circle-fill"></i> No incidents found in records.
                        </div>
                    @else
                    <table class="table table-hover table-striped mb-0" style="table-layout: fixed; width: 100%">
                        <thead class="table-danger">
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Reporter</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="incidentsTableBody">
                            <!-- Hardcoded values -->
                            <tr>
                                <td>1</td>
                                <td>Public Disturbance</td>
                                <td>May 15, 2023 10:30 AM</td>
                                <td>Main Street</td>
                                <td>Luig</td>
                                <td>09123456789</td>
                                <td>
                                    <span class="status-badge status-pending">
                                        Pending
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" id="dropdownMenuButton1" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                            <li><a class="dropdown-item edit-incident" href="#" data-id="1"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                            <li><a class="dropdown-item delete-incident" href="#" data-id="1"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Noise Complaint</td>
                                <td>May 14, 2023 11:45 PM</td>
                                <td>Pine Street</td>
                                <td>Earl</td>
                                <td>09234567890</td>
                                <td>
                                    <span class="status-badge status-ongoing">
                                        Ongoing
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" id="dropdownMenuButton2" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                            <li><a class="dropdown-item edit-incident" href="#" data-id="2"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                            <li><a class="dropdown-item delete-incident" href="#" data-id="2"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Property Damage</td>
                                <td>May 10, 2023 3:15 PM</td>
                                <td>Oak Street</td>
                                <td>Nicole</td>
                                <td>09345678901</td>
                                <td>
                                    <span class="status-badge status-resolved">
                                        Resolved
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" id="dropdownMenuButton3" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton3">
                                            <li><a class="dropdown-item edit-incident" href="#" data-id="3"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                            <li><a class="dropdown-item delete-incident" href="#" data-id="3"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @isset($incidents)
                                @foreach($incidents as $incident)
                                    <tr>
                                        <td>{{ $incident->id }}</td>
                                        <td>{{ $incident->incident_type }}</td>
                                        <td>{{ optional($incident->incident_date)->format('M j, Y g:i A') ?? 'N/A' }}</td>
                                        <td>{{ $incident->location }}</td>
                                        <td>{{ $incident->reporter_name }}</td>
                                        <td>{{ $incident->reporter_contact }}</td>
                                        <td>
                                            <span class="status-badge 
                                                @if($incident->status === 'Pending') status-pending
                                                @elseif($incident->status === 'Ongoing') status-ongoing
                                                @else status-resolved @endif">
                                                {{ $incident->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                        type="button" id="dropdownMenuButton{{ $incident->id }}" 
                                                        data-bs-toggle="dropdown" 
                                                        aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $incident->id }}">
                                                    <li><a class="dropdown-item edit-incident" href="#" data-id="{{ $incident->id }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item delete-incident" href="#" data-id="{{ $incident->id }}"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Report Incident Modal -->
    <div class="modal fade" id="reportIncidentModal" tabindex="-1" aria-labelledby="reportIncidentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="reportIncidentModalLabel">Report New Incident</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="incidentForm" action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editIncidentId" name="id" value="">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="incidentType" class="form-label">Incident Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="incidentType" name="incidentType" required>
                                <option value="" selected disabled>Select incident type</option>
                                <option value="Public Disturbance">Public Disturbance</option>
                                <option value="Property Damage">Property Damage</option>
                                <option value="Noise Complaint">Noise Complaint</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="incidentDate" class="form-label">Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" id="incidentDate" name="incidentDate" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="reporterName" class="form-label">Reporter Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="reporterName" name="reporterName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="reporterContact" class="form-label">Contact Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="reporterContact" name="reporterContact" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="incidentLocation" class="form-label">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="incidentLocation" name="location" required>
                        </div>
                        <div class="col-md-6">
                            <label for="incidentStatus" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="incidentStatus" name="status" required>
                                <option value="Pending">Pending</option>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Resolved">Resolved</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="incidentDescription" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="incidentDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="incidentProofs" class="form-label">Upload Proofs (Optional)</label>
                        <input type="file" class="form-control" id="incidentProofs" name="proofs[]" multiple accept="image/*">
                        <div class="image-preview-container" id="imagePreviewContainer"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- Loading Backdrop -->
    <div class="custom-loading-backdrop d-none" id="loadingBackdrop"></div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Search functionality
document.getElementById('searchInput')?.addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#incidentsTableBody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

// Image preview for file upload
document.getElementById('incidentProofs')?.addEventListener('change', function() {
    const previewContainer = document.getElementById('imagePreviewContainer');
    previewContainer.innerHTML = '';
    
    if (this.files) {
        Array.from(this.files).forEach(file => {
            if (file.type.match('image.*')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'image-preview';
                    previewContainer.appendChild(img);
                }
                
                reader.readAsDataURL(file);
            }
        });
    }
});

// Form submission handling
// Form submission handling
document.getElementById('incidentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    const modal = bootstrap.Modal.getInstance(document.getElementById('reportIncidentModal'));
    const isEdit = !!document.getElementById('editIncidentId').value;
    const method = isEdit ? 'PUT' : 'POST';
    const url = isEdit ? `/incidents/${document.getElementById('editIncidentId').value}` : form.action;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

    const formData = new FormData(form);
    formData.append('_method', method);

    fetch(url, {
        method: 'POST', // Always use POST but simulate PUT/PATCH with _method
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            if (isEdit) {
                updateIncidentInTable(data.incident);
            } else {
                addIncidentToTable(data.incident);
            }
            
            // Reset the form
            resetForm();
            
            // Properly hide the modal and clean up backdrops
            modal.hide();
            removeAllBackdrops();
            
            // Show success message
            showToast(`Incident ${isEdit ? 'updated' : 'reported'} successfully!`);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error submitting report. Please try again.', 'danger');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = isEdit ? 'Update Report' : 'Submit Report';
    });
});

// Helper functions
function removeAllBackdrops() {
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach(backdrop => backdrop.remove());
    document.body.classList.remove('modal-open');
    document.body.style.overflow = 'visible';
    document.body.style.paddingRight = '0px';
}

function resetForm() {
    document.getElementById('incidentForm').reset();
    document.getElementById('editIncidentId').value = '';
    document.getElementById('imagePreviewContainer').innerHTML = '';
    document.getElementById('reportIncidentModalLabel').textContent = 'Report New Incident';
}

function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toastContainer') || createToastContainer();
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0 show`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    toastContainer.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 5000);
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toastContainer';
    container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
    container.style.zIndex = '1100';
    document.body.appendChild(container);
    return container;
}

function addIncidentToTable(incident) {
    let tbody = document.querySelector('#incidentsTableBody');
    
    if (!tbody) {
        const tableContainer = document.querySelector('.table-responsive');
        const alerts = document.querySelectorAll('.alert-info');
        alerts.forEach(alert => alert.remove());
        
        tableContainer.innerHTML = `
            <table class="table table-hover table-striped mb-0">
                <thead class="table-danger">
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Reporter</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="incidentsTableBody"></tbody>
            </table>
        `;
        
        tbody = document.querySelector('#incidentsTableBody');
    }

    const newRow = createIncidentRow(incident);
    tbody.insertBefore(newRow, tbody.firstChild);
    attachActionListeners(newRow);
}

function updateIncidentInTable(incident) {
    const row = document.querySelector(`tr:has(.edit-incident[data-id="${incident.id}"])`);
    if (row) {
        const newRow = createIncidentRow(incident);
        row.replaceWith(newRow);
        attachActionListeners(newRow);
    }
}

function createIncidentRow(incident) {
    const incidentDate = new Date(incident.incident_date);
    const formattedDate = incidentDate.toLocaleString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    });

    let statusClass = 'status-pending';
    if (incident.status === 'Ongoing') statusClass = 'status-ongoing';
    if (incident.status === 'Resolved') statusClass = 'status-resolved';

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>${incident.id}</td>
        <td>${incident.incident_type}</td>
        <td>${formattedDate}</td>
        <td>${incident.location}</td>
        <td>${incident.reporter_name}</td>
        <td>${incident.reporter_contact}</td>
        <td>
            <span class="status-badge ${statusClass}">
                ${incident.status}
            </span>
        </td>
        <td>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                        type="button" id="dropdownMenuButton${incident.id}" 
                        data-bs-toggle="dropdown" 
                        aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton${incident.id}">
                    <li><a class="dropdown-item edit-incident" href="#" data-id="${incident.id}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                    <li><a class="dropdown-item delete-incident" href="#" data-id="${incident.id}"><i class="bi bi-trash me-2"></i>Delete</a></li>
                </ul>
            </div>
        </td>
    `;
    
    return newRow;
}

function attachActionListeners(row) {
    const deleteBtn = row.querySelector('.delete-incident');
    const editBtn = row.querySelector('.edit-incident');
    
    // Clone elements to remove existing listeners
    const newDeleteBtn = deleteBtn.cloneNode(true);
    const newEditBtn = editBtn.cloneNode(true);
    
    deleteBtn.replaceWith(newDeleteBtn);
    editBtn.replaceWith(newEditBtn);
    
    newDeleteBtn.addEventListener('click', deleteIncidentHandler);
    newEditBtn.addEventListener('click', editIncidentHandler);
}

function deleteIncidentHandler(e) {
    e.preventDefault();
    const incidentId = this.getAttribute('data-id');
    
    if (confirm('Are you sure you want to delete this incident?')) {
        document.getElementById('loadingBackdrop').classList.remove('d-none');
        
        fetch(`/incidents/${incidentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.closest('tr').remove();
                showToast('Incident deleted successfully!');
                
                if (!document.querySelector('#incidentsTableBody')?.children?.length) {
                    const tableContainer = document.querySelector('.table-responsive');
                    tableContainer.innerHTML = `
                        <div class="alert alert-info m-3">
                            <i class="bi bi-info-circle-fill"></i> No incidents found in records.
                        </div>
                    `;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error deleting incident. Please try again.', 'danger');
        })
        .finally(() => {
            document.getElementById('loadingBackdrop').classList.add('d-none');
        });
    }
}

function editIncidentHandler(e) {
    e.preventDefault();
    const incidentId = this.getAttribute('data-id');
    
    document.getElementById('loadingBackdrop').classList.remove('d-none');
    
    fetch(`/incidents/${incidentId}/edit`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
        },
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.incident) {
            const incident = data.incident;
            const modal = new bootstrap.Modal(document.getElementById('reportIncidentModal'));
            
            document.getElementById('editIncidentId').value = incident.id;
            document.getElementById('incidentType').value = incident.incident_type;
            document.getElementById('incidentDate').value = formatDateTimeForInput(incident.incident_date);
            document.getElementById('reporterName').value = incident.reporter_name;
            document.getElementById('reporterContact').value = incident.reporter_contact;
            document.getElementById('incidentLocation').value = incident.location;
            document.getElementById('incidentStatus').value = incident.status; // Set status value
            document.getElementById('incidentDescription').value = incident.description;
            
            document.getElementById('reportIncidentModalLabel').textContent = 'Edit Incident';
            modal.show();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error loading incident details. Please try again.', 'danger');
    })
    .finally(() => {
        document.getElementById('loadingBackdrop').classList.add('d-none');
    });
}

function createIncidentRow(incident) {
    const incidentDate = new Date(incident.incident_date);
    const formattedDate = incidentDate.toLocaleString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    });

    let statusClass = 'status-pending';
    if (incident.status === 'Ongoing') statusClass = 'status-ongoing';
    if (incident.status === 'Resolved') statusClass = 'status-resolved';

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>${incident.id}</td>
        <td>${incident.incident_type}</td>
        <td>${formattedDate}</td>
        <td>${incident.location}</td>
        <td>${incident.reporter_name}</td>
        <td>${incident.reporter_contact}</td>
        <td>
            <span class="status-badge ${statusClass}">
                ${incident.status}
            </span>
        </td>
        <td>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                        type="button" id="dropdownMenuButton${incident.id}" 
                        data-bs-toggle="dropdown" 
                        aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton${incident.id}">
                    <li><a class="dropdown-item edit-incident" href="#" data-id="${incident.id}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                    <li><a class="dropdown-item delete-incident" href="#" data-id="${incident.id}"><i class="bi bi-trash me-2"></i>Delete</a></li>
                </ul>
            </div>
        </td>
    `;
    
    return newRow;
}

function formatDateTimeForInput(dateTimeString) {
    const date = new Date(dateTimeString);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    
    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

// Initialize dropdowns and event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all dropdowns
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        const button = dropdown.querySelector('.dropdown-toggle');
        new bootstrap.Dropdown(button);
    });

    // Fix for multiple backdrops
    document.addEventListener('show.bs.modal', function(event) {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        if (backdrops.length > 1) {
            backdrops.forEach((backdrop, index) => {
                if (index > 0) {
                    backdrop.remove();
                }
            });
        }
    });

    // Reset form when modal is hidden
    document.getElementById('reportIncidentModal')?.addEventListener('hidden.bs.modal', function() {
        resetForm();
    });
});
</script>
</body>
</html>