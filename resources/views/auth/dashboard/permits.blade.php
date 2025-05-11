<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Laravel CSRF Token -->
  <title>Barangay Permits</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
.view-requests-btn {
background-color: #0d6efd;
color: white;
border: none;
padding: 8px 16px;
border-radius: 4px;
font-weight: 500;
transition: background-color 0.3s;
}
.view-requests-btn:hover {
background-color: #0b5ed7;
}
.table th {
white-space: nowrap;
}
.edit-btn, .delete-btn {
margin-right: 5px;
}
:root {
--primary-blue: #2563eb;
--dark-blue: #1e40af;
--success-green: #28a745;
--dark-green: #218838;
--light-gray: #f8f9fa;
--border-gray: #dee2e6;
--text-dark: #333;
}

body {
font-family: 'Inter', sans-serif;
background-color: var(--light-gray);
padding-top: 3rem;
}

.permit-card {
border-radius: 0.625rem;
border: 1px solid var(--border-gray);
transition: transform 0.3s ease;
height: 110%;
display: flex;
flex-direction: column;
background: white;
}

.permit-card:hover {
transform: translateY(-5px);
box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.permit-header {
background-color: white;
padding: 1.25rem;
border-top-left-radius: 0.625rem;
border-top-right-radius: 0.625rem;
border-bottom: 1px solid var(--border-gray);
position: relative;
}

.permit-title {
font-weight: 600;
font-size: 1.25rem;
color: var(--dark-blue);
padding-left: 3rem;
margin: 0;
}

.permit-icon {
width: 48px;
height: 48px;
position: absolute;
left: 1rem;
top: 50%;
transform: translateY(-50%);
}

.status-badge {
background-color: var(--success-green);
color: white;
padding: 0.25rem 0.75rem;
border-radius: 1rem;
font-size: 0.8rem;
display: inline-block;
}

.fee {
font-weight: 500;
color: var(--text-dark);
}

.btn-request {
background-color: var(--primary-blue);
color: white;
font-weight: 600;
padding: 0.3rem 1rem;
}

.btn-request:hover {
background-color: var(--dark-blue);
}

.card-content {
padding: 1.25rem;
flex-grow: 2;
display: flex;
flex-direction: column;
}

.card-actions {
margin-top: auto;
}

.view-requests-btn {
background-color: var(--success-green);
color: white;
font-weight: 600;
padding: 0.5rem 1.5rem;
border-radius: 0.5rem;
border: none;
}

.view-requests-btn:hover {
background-color: var(--dark-green);
}

.permit-container {
display: grid;
grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
gap: 2.0rem;
width: 100%;
}

/* Modal Styles */
.modal-permit-icon {
width: 60px;
height: 60px;
margin-right: 1rem;
}

.modal-permit-title {
font-size: 1.5rem;
font-weight: 600;
color: var(--dark-blue);
}

.modal-permit-fee {
font-size: 1.1rem;
color: var(--text-dark);
margin-bottom: 1rem;
}

.form-label {
font-weight: 500;
margin-bottom: 0.25rem;
font-size: 0.9rem;
}

.required-field::after {
content: " *";
color: #dc3545;
}

.form-control, .form-select {
padding: 0.5rem 0.75rem;
border-radius: 0.375rem;
font-size: 0.9rem;
}

.section-title {
font-size: 1rem;
font-weight: 600;
color: var(--dark-blue);
margin: 1rem 0 0.75rem;
padding-bottom: 0.25rem;
border-bottom: 1px solid var(--border-gray);
}

.upload-section {
background-color: #f8f9fa;
border-radius: 0.5rem;
padding: 1rem;
margin-bottom: 1rem;
}

.modal-dialog-custom {
max-width: 600px;
margin: 0.5rem auto;
}

@media (max-width: 768px) {
.permit-container {
  grid-template-columns: 1fr;
}
}
</style>
</head>
<body class="pt-3">
  <div class="container px-4 py-4" style="max-width: 1140px;">
    <!-- Success/Error Messages -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="fs-2 fw-semibold text-gray-900 mb-0">Barangay Permits</h1>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestsModal">
  <i class="fas fa-list-check me-2"></i>View Requests
</button>    </div>

    <div class="permit-container">
      <!-- Barangay Clearance -->
      <div class="permit-card">
        <div class="permit-header">
          <img src="{{ asset('downloads/permits/approved.png') }}" alt="Clearance Icon" class="permit-icon" />
          <h3 class="permit-title">Barangay Clearance</h3>
        </div>
        <div class="card-content">
          <p class="mb-2"><span class="status-badge">Available</span></p>
          <p class="fee mb-4">Fee: ₱100</p>
          <div class="card-actions">
            <button class="btn btn-request w-100" data-bs-toggle="modal" data-bs-target="#barangayClearanceModal">Request</button>
          </div>
        </div>
      </div>
      
      <!-- Certificate of Residency -->
      <div class="permit-card">
        <div class="permit-header">
          <img src="{{ asset('downloads/permits/sms.png') }}" alt="Residency Icon" class="permit-icon" />
          <h3 class="permit-title">Certificate of Residency</h3>
        </div>
        <div class="card-content">
          <p class="mb-2"><span class="status-badge">Available</span></p>
          <p class="fee mb-4">Fee: ₱75</p>
          <div class="card-actions">
            <button class="btn btn-request w-100" data-bs-toggle="modal" data-bs-target="#residencyModal">Request</button>
          </div>
        </div>
      </div>
      
      <!-- Business Permit -->
      <div class="permit-card">
        <div class="permit-header">
          <img src="{{ asset('downloads/permits/bus.png') }}" alt="Business Icon" class="permit-icon" />
          <h3 class="permit-title">Business Permit</h3>
        </div>
        <div class="card-content">
          <p class="mb-2"><span class="status-badge">Available</span></p>
          <p class="fee mb-4">Fee: ₱100</p>
          <div class="card-actions">
            <button class="btn btn-request w-100" data-bs-toggle="modal" data-bs-target="#businessPermitModal">Request</button>
          </div>
        </div>
      </div>
      
      <!-- Barangay ID -->
      <div class="permit-card">
        <div class="permit-header">
          <img src="{{ asset('downloads/permits/license.png') }}" alt="ID Icon" class="permit-icon" />
          <h3 class="permit-title">Barangay ID</h3>
        </div>
        <div class="card-content">
          <p class="mb-2"><span class="status-badge">Available</span></p>
          <p class="fee mb-4">Fee: ₱150</p>
          <div class="card-actions">
            <button class="btn btn-request w-100" data-bs-toggle="modal" data-bs-target="#barangayIdModal">Request</button>
          </div>
        </div>
      </div>

<!-- Requests Modal -->
<div class="modal fade" id="requestsModal" tabindex="-1" aria-labelledby="requestsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="requestsModalLabel">
          My Requests <span class="badge bg-white text-primary" id="requestsCount">0</span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Request ID</th>
                <th scope="col">Type</th>
                <th scope="col">Full Name</th>
                <th scope="col">Date Requested</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody id="requestsTableBody">
              <!-- Will be populated by JavaScript -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <!-- Barangay Clearance Modal -->
<div class="modal fade" id="barangayClearanceModal" tabindex="-1" aria-labelledby="barangayClearanceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" style="max-height: 85vh;">
      <div class="modal-header bg-light sticky-top">
        <div class="d-flex align-items-center">
          <img src="{{ asset('downloads/permits/approved.png') }}" alt="Permit Icon" width="40" height="40">
          <div class="ms-3">
            <h5 class="modal-title fw-bold mb-0 text-primary">Barangay Clearance</h5>
            <small class="text-muted">Fee: ₱100.00</small>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4" style="overflow-y: auto;">
        <form method="POST" action="{{ route('permits.clearance.store') }}" id="clearanceForm" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="type" value="Barangay Clearance">
          
          <!-- Personal Information Section -->
          <div class="mb-4">
            <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Personal Information</h6>
            
            <div class="row g-3">
              <div class="col-md-12">
                <label for="bcFullName" class="form-label required">Full Name</label>
                <input type="text" class="form-control" id="bcFullName" name="full_name" required>
              </div>
              
              <div class="col-md-4">
                <label for="bcBirthdate" class="form-label required">Birthdate</label>
                <input type="date" class="form-control" id="bcBirthdate" name="birthdate" required>
              </div>
              <div class="col-md-3">
                <label for="bcGender" class="form-label required">Gender</label>
                <select class="form-select" id="bcGender" name="gender" required>
                  <option value="">Select...</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              
              <div class="col-md-3">
                <label for="bcCivilStatus" class="form-label required">Civil Status</label>
                <select class="form-select" id="bcCivilStatus" name="civil_status" required>
                  <option value="">Select...</option>
                  <option value="Single">Single</option>
                  <option value="Married">Married</option>
                  <option value="Widowed">Widowed</option>
                  <option value="Separated">Separated</option>
                </select>
              </div>
              
              <div class="col-md-12">
                <label for="bcAddress" class="form-label required">Complete Address</label>
                <textarea class="form-control" id="bcAddress" name="address" rows="2" required></textarea>
              </div>
              
              <div class="col-md-6">
                <label for="bcContact" class="form-label required">Contact Number</label>
                <input type="tel" class="form-control" id="bcContact" name="contact_number" required>
              </div>
            </div>
          </div>
          
          <!-- Request Details Section -->
          <div class="mb-4">
            <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Request Details</h6>
            
            <div class="row g-3">
              <div class="col-md-12">
                <label for="bcPurpose" class="form-label required">Purpose</label>
                <textarea class="form-control" id="bcPurpose" name="purpose" rows="3" required></textarea>
              </div>
            </div>
          </div>
          
          <div class="modal-footer bg-light sticky-bottom">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Submit Request</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

  <!-- Certificate of Residency Modal -->
<div class="modal fade" id="residencyModal" tabindex="-1" aria-labelledby="residencyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-custom">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <div class="d-flex align-items-center">
          <img src="{{ asset('downloads/permits/sms.png') }}" alt="Permit Icon" class="modal-permit-icon">
          <div>
            <h5 class="modal-title modal-permit-title mb-1">Certificate of Residency</h5>
            <p class="modal-permit-fee mb-0">Fee: ₱75</p>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-1">
      <form method="POST" action="{{ route('permits.residency.store') }}" enctype="multipart/form-data">  @csrf
  <input type="hidden" name="permit_type" value="residency">
  
  <div class="mb-3">
    <label for="crFullName" class="form-label required-field">Full Name</label>
    <input type="text" class="form-control" id="crFullName" name="full_name" required>
  </div>
  
  <div class="row mb-3">
    <div class="col-md-6">
      <label for="crBirthdate" class="form-label required-field">Birthdate</label>
      <input type="date" class="form-control" id="crBirthdate" name="birthdate" required>
    </div>
    <div class="col-md-6">
      <label for="crAge" class="form-label required-field">Age</label>
      <input type="number" class="form-control" id="crAge" name="age" required>
    </div>
  </div>
  
  <div class="mb-3">
    <label for="crAddress" class="form-label required-field">Complete Address (with Purok/Sitio)</label>
    <textarea class="form-control" id="crAddress" name="address" rows="2" required></textarea>
  </div>
  
  <div class="mb-3">
    <label for="crContact" class="form-label required-field">Contact Number</label>
    <input type="tel" class="form-control" id="crContact" name="contact_number" required>
  </div>
  
  <div class="mb-3">
    <label for="crYearsResidency" class="form-label required-field">Years of Residency</label>
    <input type="number" class="form-control" id="crYearsResidency" name="years_residency" required>
  </div>
  
  <div class="mb-3">
    <label for="crPurpose" class="form-label required-field">Purpose of Request</label>
    <textarea class="form-control" id="crPurpose" name="purpose" rows="2" required></textarea>
  </div>

  <div class="modal-footer border-0 pt-4 px-0">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-primary">Submit Request</button>
  </div>
</form>
      </div>
    </div>
  </div>
</div>

 <!-- Business Permit Modal -->
<div class="modal fade" id="businessPermitModal" tabindex="-1" aria-labelledby="businessPermitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-custom">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <div class="d-flex align-items-center">
          <img src="{{ asset('downloads/permits/bus.png') }}" alt="Permit Icon" class="modal-permit-icon">
          <div>
            <h5 class="modal-title modal-permit-title mb-1">Business Permit</h5>
            <p class="modal-permit-fee mb-0">Fee: ₱100</p>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body pt-1">
        <form method="POST" action="{{ route('permits.business.store') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="type" value="Business Permit">

          <div class="mb-3">
            <label class="form-label required-field">Business Name</label>
            <input type="text" class="form-control" name="business_name" required>
          </div>

          <div class="mb-3">
            <label class="form-label required-field">Business Owner's Full Name</label>
            <input type="text" class="form-control" name="full_name" required>
          </div>

          <div class="mb-3">
            <label class="form-label required-field">Business Address</label>
            <textarea class="form-control" name="business_address" rows="2" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label required-field">Type of Business</label>
            <input type="text" class="form-control" name="business_type" required>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">TIN</label>
              <input type="text" class="form-control" name="tin">
            </div>
            <div class="col-md-6">
              <label class="form-label">DTI Registration No.</label>
              <input type="text" class="form-control" name="dti_number">
            </div>
          </div>

          <!-- Required Base Fields -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label required-field">Birthdate</label>
              <input type="date" class="form-control" name="birthdate" required>
            </div>

          <div class="mb-3">
            <label class="form-label required-field">Full Address</label>
            <textarea class="form-control" name="address" rows="2" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label required-field">Contact Number</label>
            <input type="tel" class="form-control" name="contact_number" required>
          </div>

          <div class="modal-footer border-0 pt-4 px-0">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Submit Request</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>


<!-- Barangay ID Modal -->
<div class="modal fade" id="barangayIdModal" tabindex="-1" aria-labelledby="barangayIdModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content" style="max-height: 90vh;">
      <div class="modal-header bg-light sticky-top">
        <div class="d-flex align-items-center">
          <img src="{{ asset('downloads/permits/license.png') }}" alt="ID Icon" width="40" height="40">
          <div class="ms-3">
            <h5 class="modal-title fw-bold mb-0 text-primary">Barangay ID Application</h5>
            <small class="text-muted">Fee: ₱150.00</small>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4" style="overflow-y: auto;">
        <form method="POST" action="{{ route('permits.id.store') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="date_requested" value="{{ now()->format('Y-m-d') }}">

          <!-- Personal Information Section -->
          <div class="mb-4">
            <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Personal Information</h6>

            <div class="row g-3">
              <div class="col-md-12">
                <label for="biFullName" class="form-label required">Full Name</label>
                <input type="text" class="form-control" id="biFullName" name="full_name" required>
              </div>

              <div class="col-md-6">
                <label for="biBirthdate" class="form-label required">Birthdate</label>
                <input type="date" class="form-control" id="biBirthdate" name="birthdate" required>
              </div>

              <div class="col-md-3">
                <label for="biGender" class="form-label required">Gender</label>
                <select class="form-select" id="biGender" name="gender" required>
                  <option value="">Select...</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <div class="col-md-3">
                <label for="biCivilStatus" class="form-label required">Civil Status</label>
                <select class="form-select" id="biCivilStatus" name="civil_status" required>
                  <option value="">Select...</option>
                  <option value="Single">Single</option>
                  <option value="Married">Married</option>
                  <option value="Widowed">Widowed</option>
                  <option value="Separated">Separated</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="biCitizenship" class="form-label required">Citizenship</label>
                <input type="text" class="form-control" id="biCitizenship" name="citizenship" placeholder="Filipino" required>
              </div>

              <div class="col-md-6">
                <label for="biContact" class="form-label required">Contact Number</label>
                <input type="tel" class="form-control" id="biContact" name="contact_number" placeholder="09123456789" required>
              </div>

              <div class="col-md-12">
                <label for="biAddress" class="form-label required">Complete Address</label>
                <textarea class="form-control" id="biAddress" name="address" rows="2" placeholder="House #, Street, Barangay" required></textarea>
              </div>
            </div>
          </div>
          <div class="mb-4">
  <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Emergency Contact</h6>
  <div class="row g-3">
    <div class="col-md-6">
      <label for="biEmergencyName" class="form-label required">Contact Person</label>
      <input type="text" class="form-control" id="biEmergencyName" name="emergency_name" placeholder="Full name of emergency contact" required>
    </div>
    <!-- ... -->
  </div>
</div>

<!-- Photo Upload Section -->
<div class="mb-4">
  <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Photo Requirements</h6>
  <div class="row g-3">
    <div class="col-md-12">
      <div class="card border-primary">
        <div class="card-body">
          <label for="biPhoto" class="form-label required">Upload ID Photo</label>
          <input type="file" class="form-control" id="biPhoto" name="photo" accept="image/*" required>
         <small class="text-muted">Please upload a clear 1x1 or 2x2 photo with white background</small>
        </div>
      </div>
    </div>
  </div>
</div>                                                                
<!-- Footer -->
<div class="modal-footer bg-light sticky-bottom">
  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
  <button type="submit" class="btn btn-primary px-4">Submit Application</button>
</div>

</form>
</div>
</div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
// CORE FUNCTIONS
console.log(document.getElementById('barangayIdModal').getBoundingClientRect());
function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
        setTimeout(() => {
            new bootstrap.Alert(alertDiv).close();
        }, 5000);
    }
}
// Show My Requests modal after submission
const requestsModalElement = document.getElementById('requestsModal');
if (requestsModalElement) {
    const myRequestsModal = new bootstrap.Modal(requestsModalElement);
    myRequestsModal.show();
}

//Gets color for status badge 
function getStatusColor(status) {
    const statusColors = {
        'approved': 'success',
        'rejected': 'danger', 
        'pending': 'warning'
    };
    return statusColors[status.toLowerCase()] || 'secondary';
}

// REQUEST HANDLING
async function loadRequests() {
    const tbody = document.getElementById('requestsTableBody');
    const countBadge = document.getElementById('requestsCount');
    
    try {
        // Show loading state
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4"><div class="spinner-border" role="status"></div></td></tr>';
        
        const response = await fetch("{{ route('api.permits.index') }}", {
    method: 'GET',
    credentials: 'same-origin', // ✅ include cookies/session
    headers: {
        'Accept': 'application/json'
    }
});
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const requests = await response.json();
        
        // Update table
        tbody.innerHTML = requests.length ? '' : '<tr><td colspan="7" class="text-center py-4">No requests found</td></tr>';
        
        requests.forEach((request, index) => {
          tbody.innerHTML += `
    <tr>
        <th scope="row">${index + 1}</th>
        <td>${request.id}</td>
        <td>${request.type}</td>
        <td>${request.full_name}</td>
        <td>${new Date(request.created_at).toLocaleDateString()}</td>
        <td><span class="badge bg-${getStatusColor(request.status)}">${request.status}</span></td>
        <td>
            <button class="btn btn-sm btn-outline-primary me-1">
                <i class="bi bi-pencil-square"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>
`;
        });
        
        // Update count badge
        countBadge.textContent = requests.length;
        
    } catch (error) {
        console.error('Failed to load requests:', error);
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-danger py-4">
                    Failed to load requests. Please try again.
                </td>
            </tr>
        `;
    }
}
 //Handles form submission
async function handleFormSubmit(form) {
    const modal = bootstrap.Modal.getInstance(form.closest('.modal'));
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </span> Processing...
    `;

    try {
        const formData = new FormData(form);
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Submission failed');
        }

        showAlert('success', result.message || 'Request submitted!');
        
        if (modal) {
            modal.hide();
            form.reset();
        }

        // Show the requests modal after successful submission
        const requestsModalElement = document.getElementById('requestsModal');
        if (requestsModalElement) {
            const requestsModalInstance = bootstrap.Modal.getOrCreateInstance(requestsModalElement);
            requestsModalInstance.show();
        }

        // Refresh the requests list
        await loadRequests();

    } catch (error) {
        console.error('Submission error:', error);
        showAlert('danger', error.message || 'Submission failed. Please try again.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
}
// EVENT LISTENERS
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        handleFormSubmit(form);
    });
});

// Load requests when modal opens
const requestsModal = document.getElementById('requestsModal');
if (requestsModal) {
    requestsModal.addEventListener('shown.bs.modal', loadRequests);
    
    // Cleanup on modal close
    requestsModal.addEventListener('hidden.bs.modal', () => {
        document.body.classList.remove('modal-open');
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    });
}


</script>
</body>
</html>