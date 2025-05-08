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
padding-top: 1rem;
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

    @if($errors->any()))
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
      <button class="view-requests-btn" data-bs-toggle="modal" data-bs-target="#requestsModal">View Requests</button>
    </div>

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
            <h5 class="modal-title" id="requestsModalLabel">My Requests</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="table-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody id="requestsTableBody">
                  <!-- Dynamically loaded via AJAX -->
                  <tr>
                    <td colspan="6" class="text-center">Loading requests...</td>
                  </tr>
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
          <div class="modal-body p-4" style="overflow-y: auto;"> <!-- Scrollable content -->

          <form method="POST" action="{{ route('permits.clearance.store') }}">
            @csrf
              <!-- Personal Information Section -->
              <div class="mb-4">
                <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Personal Information</h6>
                
                <div class="row g-3">
                  <div class="col-md-12">
                    <label for="bcFullName" class="form-label required">Full Name</label>
                    <input type="text" class="form-control" id="bcFullName" name="full_name" value="Luigi A Ednilan" required>
                  </div>
                  
                  <div class="col-md-4">
                    <label for="bcBirthdate" class="form-label required">Birthdate</label>
                    <input type="date" class="form-control" id="bcBirthdate" name="birthdate" value="2003-01-01" required>
                  </div>
                  
                  <div class="col-md-2">
                    <label for="bcAge" class="form-label required">Age</label>
                    <input type="number" class="form-control" id="bcAge" name="age" min="1" value="20" required>
                  </div>
                  
                  <div class="col-md-3">
                    <label for="bcGender" class="form-label required">Gender</label>
                    <select class="form-select" id="bcGender" name="gender" required>
                      <option value="Male" selected>Male</option>
                      <option value="Female">Female</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>
                  
                  <div class="col-md-3">
                    <label for="bcCivilStatus" class="form-label required">Civil Status</label>
                    <select class="form-select" id="bcCivilStatus" name="civil_status" required>
                      <option value="Single" selected>Single</option>
                      <option value="Married">Married</option>
                      <option value="Widowed">Widowed</option>
                      <option value="Separated">Separated</option>
                    </select>
                  </div>
                  
                  <div class="col-md-12">
                    <label for="bcAddress" class="form-label required">Complete Address</label>
                    <textarea class="form-control" id="bcAddress" name="address" rows="2" required>123 Sample Street, Barangay Sample</textarea>
                  </div>
                  
                  <div class="col-md-6">
                    <label for="bcContact" class="form-label required">Contact Number</label>
                    <input type="tel" class="form-control" id="bcContact" name="contact_number" value="09123456789" required>
                  </div>
                </div>
              </div>
              
              <!-- Request Details Section -->
              <div class="mb-4">
                <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Request Details</h6>
                
                <div class="row g-3">
                  <div class="col-md-12">
                    <label for="bcPurpose" class="form-label required">Purpose</label>
                    <textarea class="form-control" id="bcPurpose" name="purpose" rows="3" required>For presentation purposes only</textarea>
                  </div>
                     <div class="col-md-6">
                    <label for="bcDateRequest" class="form-label required">Date of Request</label>
                    <input type="date" class="form-control" id="bcDateRequest" name="date_requested" value="<?php echo date('Y-m-d'); ?>" required>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="modal-footer bg-light sticky-bottom">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary px-4" onclick="showSubmissionAlert(event)">Submit Request</button>
            </div>
          </form>
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
        <form method="POST" action="{{ route('permits.residency.store') }}">
        @csrf           
         <div class="mb-3">
              <label for="crFullName" class="form-label required-field">Full Name</label>
              <input type="text" class="form-control" id="crFullName" value="Luigi A Ednilan" required>
            </div>
            
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="crBirthdate" class="form-label required-field">Birthdate</label>
                <input type="date" class="form-control" id="crBirthdate" value="2003-01-01" required>
              </div>
              <div class="col-md-6">
                <label for="crAge" class="form-label required-field">Age</label>
                <input type="number" class="form-control" id="crAge" value="20" required>
              </div>
            </div>
            
            <div class="mb-3">
              <label for="crAddress" class="form-label required-field">Complete Address (with Purok/Sitio)</label>
              <textarea class="form-control" id="crAddress" rows="2" required>123 Sample Street, Barangay Sample</textarea>
            </div>
            
            <div class="mb-3">
              <label for="crContact" class="form-label required-field">Contact Number</label>
              <input type="tel" class="form-control" id="crContact" value="09123456789" required>
            </div>
            
            <div class="mb-3">
              <label for="crYearsResidency" class="form-label required-field">Years of Residency</label>
              <input type="number" class="form-control" id="crYearsResidency" value="5" required>
            </div>
            
            <div class="mb-3">
              <label for="crPurpose" class="form-label required-field">Purpose of Request</label>
              <textarea class="form-control" id="crPurpose" rows="2" required>For presentation purposes only</textarea>
            </div>
            
            <div class="mb-3">
              <label for="crDateRequest" class="form-label required-field">Date of Request</label>
              <input type="date" class="form-control" id="crDateRequest" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            
            <div class="modal-footer border-0 pt-4 px-0">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary" onclick="showSubmissionAlert(event)">Submit Request</button>
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
        <form method="POST" action="{{ route('permits.business.store') }}">
        @csrf
              <div class="mb-3">
              <label for="bpBusinessName" class="form-label required-field">Business Name</label>
              <input type="text" class="form-control" id="bpBusinessName" value="Luigi's Sample Business" required>
            </div>
            
            <div class="mb-3">
              <label for="bpOwnerName" class="form-label required-field">Business Owner's Full Name</label>
              <input type="text" class="form-control" id="bpOwnerName" value="Luigi A Ednilan" required>
            </div>
            
            <div class="mb-3">
              <label for="bpBusinessAddress" class="form-label required-field">Business Address</label>
              <textarea class="form-control" id="bpBusinessAddress" rows="2" required>123 Sample Street, Barangay Sample</textarea>
            </div>
            
            <div class="mb-3">
              <label for="bpBusinessType" class="form-label required-field">Type of Business</label>
              <input type="text" class="form-control" id="bpBusinessType" value="Retail" required>
            </div>
            
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="bpTin" class="form-label">TIN</label>
                <input type="text" class="form-control" id="bpTin" value="123-456-789">
              </div>
              <div class="col-md-6">
                <label for="bpDti" class="form-label">DTI Registration No.</label>
                <input type="text" class="form-control" id="bpDti" value="DTI123456789">
              </div>
            </div>
            
            <div class="mb-3">
              <label for="bpDateApplication" class="form-label required-field">Date of Application</label>
              <input type="date" class="form-control" id="bpDateApplication" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            
            <div class="mb-3">
              <label for="bpContact" class="form-label required-field">Contact Number</label>
              <input type="tel" class="form-control" id="bpContact" value="09123456789" required>
            </div>
            
            <div class="modal-footer border-0 pt-4 px-0">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary" onclick="showSubmissionAlert(event)">Submit Request</button>
            </div>
          </form>
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
      <form method="POST" action="{{ route('permits.id.store') }}">
      @csrf
          <!-- Personal Information Section -->
          <div class="mb-4">
            <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Personal Information</h6>
            
            <div class="row g-3">
              <div class="col-md-12">
                <label for="biFullName" class="form-label required">Full Name</label>
                <input type="text" class="form-control" id="biFullName" value="Luigi A Ednilan" required>
              </div>
              
              <div class="col-md-6">
                <label for="biBirthdate" class="form-label required">Birthdate</label>
                <input type="date" class="form-control" id="biBirthdate" value="2003-01-01" required>
              </div>
              
              <div class="col-md-3">
                <label for="biGender" class="form-label required">Gender</label>
                <select class="form-select" id="biGender" required>
                  <option value="Male" selected>Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              
              <div class="col-md-3">
                <label for="biCivilStatus" class="form-label required">Civil Status</label>
                <select class="form-select" id="biCivilStatus" required>
                  <option value="Single" selected>Single</option>
                  <option value="Married">Married</option>
                  <option value="Widowed">Widowed</option>
                  <option value="Separated">Separated</option>
                </select>
              </div>
              
              <div class="col-md-6">
                <label for="biCitizenship" class="form-label required">Citizenship</label>
                <input type="text" class="form-control" id="biCitizenship" value="Filipino" required>
              </div>
              
              <div class="col-md-6">
                <label for="biContact" class="form-label required">Contact Number</label>
                <input type="tel" class="form-control" id="biContact" value="09123456789" required>
              </div>
              
              <div class="col-md-12">
                <label for="biAddress" class="form-label required">Complete Address</label>
                <textarea class="form-control" id="biAddress" rows="2" required>123 Sample Street, Barangay Sample</textarea>
              </div>
            </div>
          </div>
          
          <!-- Emergency Contact Section -->
          <div class="mb-4">
            <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Emergency Contact</h6>
            
            <div class="row g-3">
              <div class="col-md-6">
                <label for="biEmergencyName" class="form-label required">Contact Person</label>
                <input type="text" class="form-control" id="biEmergencyName" value="Maria Ednilan" required>
              </div>
              
              <div class="col-md-6">
                <label for="biEmergencyNumber" class="form-label required">Contact Number</label>
                <input type="tel" class="form-control" id="biEmergencyNumber" value="09123456788" required>
              </div>
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
                    <input type="file" class="form-control" id="biPhoto" accept="image/*" required>
                    <small class="text-muted">Please upload a clear 1x1 or 2x2 photo with white background</small>
                    <div class="mt-2 text-center">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      
      <div class="modal-footer bg-light sticky-bottom">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary px-4" onclick="showSubmissionAlert(event)">Submit Application</button>
      </div>
      </form>
    </div>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
// Function to show submission alert and close modal
function showSubmissionAlert(event) {
  event.preventDefault();
  alert('Request submitted!');
  
  // Close the modal
  const modal = event.target.closest('.modal');
  if (modal) {
    const bootstrapModal = bootstrap.Modal.getInstance(modal);
    bootstrapModal.hide();
  }
}

// Function to get today's date in YYYY-MM-DD format
function getTodayDate() {
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, '0');
  const day = String(today.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}

// Set today's date for all date fields when the page loads
document.addEventListener('DOMContentLoaded', function() {
  const today = getTodayDate();
  document.querySelectorAll('input[type="date"]').forEach(dateInput => {
    dateInput.value = today;
  });
});

// Test function for direct form submission
function testSubmission() {
  const form = document.querySelector('form');
  const formData = new FormData(form);
  
  console.log('Test submission with data:', Object.fromEntries(formData.entries()));
  
  fetch('/permits/residency', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json'
    },
    body: formData
  })
  .then(response => {
    console.log('Response status:', response.status);
    return response.json().then(data => ({ status: response.status, data }));
  })
  .then(({ status, data }) => {
    console.log('Full response:', { status, data });
    if (status === 422) {
      alert('Validation errors:\n' + 
        Object.entries(data.errors || {})
          .map(([field, errors]) => `${field}: ${errors.join(', ')}`)
          .join('\n')
      );
    } else if (!status.ok) {
      alert('Error: ' + (data.message || `Status ${status}`));
    } else {
      alert('Success!');
    }
  })
  .catch(console.error);
}

// Global form submission interceptor
window.addEventListener('submit', function(e) {
  if (e.target.tagName === 'FORM') {
    console.group('[GLOBAL INTERCEPTOR] Form submission caught');
    console.log('Form action:', e.target.action);
    console.log('Form method:', e.target.method);
    console.log('Form fields:', Array.from(new FormData(e.target).entries()));
    console.groupEnd();
    
    e.preventDefault();
    e.stopImmediatePropagation();
    return false;
  }
}, true);

// Main application logic
document.addEventListener('DOMContentLoaded', function() {
  console.log('[MAIN] DOM fully loaded - initializing forms');
  
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
  console.log('[MAIN] CSRF Token:', csrfToken);

  // Process all forms
  document.querySelectorAll('form').forEach(form => {
    console.log(`[FORM] Initializing form: ${form.action}`);
    
    form.addEventListener('submit', async function(e) {
      // Prevent default behavior
      e.preventDefault();
      e.stopImmediatePropagation();
      e.stopPropagation();
      
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn?.innerHTML;
      
      try {
        // Show loading state
        if (submitBtn) {
          submitBtn.disabled = true;
          submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status"></span>
            Processing...
          `;
        }

        // Prepare and log form data
        const formData = new FormData(this);
        console.log('[SUBMIT] Form data:', Object.fromEntries(formData.entries()));

        // Submit request
        const response = await fetch(this.action, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: formData
        });

        // Process response
        const data = await response.json().catch(() => ({}));
        console.log('[SUBMIT] Response:', { status: response.status, data });

        if (!response.ok) {
          // Handle validation errors (422)
          if (response.status === 422 && data.errors) {
            const errorMessages = Object.entries(data.errors)
              .map(([field, errors]) => `• ${field}: ${errors.join(', ')}`)
              .join('\n');
            
            alert('Please fix these errors:\n' + errorMessages);
            return;
          }
          
          throw new Error(data.message || `Request failed with status ${response.status}`);
        }

        // Success handling
        alert('Request submitted successfully!');
        this.reset();

        // Close modal if in one
        const modal = this.closest('.modal');
        if (modal) {
          bootstrap.Modal.getInstance(modal)?.hide();
        }

        // Refresh requests table
        if (document.getElementById('requestsModal')) {
          await loadRequestsTable();
        }

      } catch (error) {
        console.error('[SUBMIT] Error:', error);
        alert('Submission failed: ' + error.message);
      } finally {
        // Restore button state
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        }
      }
    }, true); // Use capture phase
  });

  // Load requests table function
  async function loadRequestsTable() {
    console.log('[REQUESTS] Loading data...');
    try {
      const tbody = document.getElementById('requestsTableBody');
      if (!tbody) return;

      tbody.innerHTML = '<tr><td colspan="6" class="text-center">Loading...</td></tr>';

      const response = await fetch('/my-permit-requests');
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      
      const data = await response.json();
      console.log('[REQUESTS] Data received:', data);

      tbody.innerHTML = data.length ? '' : '<tr><td colspan="6" class="text-center">No requests</td></tr>';

      data.forEach((req, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${index + 1}</td>
          <td>${req.full_name || req.business_name || 'N/A'}</td>
          <td>${req.type || 'N/A'}</td>
          <td>${req.date || new Date().toLocaleDateString()}</td>
          <td><span class="badge bg-${getStatusColor(req.status)}">${req.status || 'Pending'}</span></td>
          <td><button class="btn btn-sm btn-outline-secondary">View</button></td>
        `;
        tbody.appendChild(row);
      });

    } catch (err) {
      console.error('[REQUESTS] Error:', err);
      const tbody = document.getElementById('requestsTableBody');
      if (tbody) {
        tbody.innerHTML = `
          <tr><td colspan="6" class="text-center text-danger">Error loading requests</td></tr>
        `;
      }
    }
  }

  // Status badge color helper
  function getStatusColor(status) {
    if (!status) return 'info';
    switch (status.toLowerCase()) {
      case 'approved': return 'success';
      case 'rejected': return 'danger';
      case 'processing': return 'warning';
      default: return 'info';
    }
  }

  // Initialize requests modal
  const requestsModal = document.getElementById('requestsModal');
  if (requestsModal) {
    requestsModal.addEventListener('show.bs.modal', loadRequestsTable);
  }

  console.log('[MAIN] Initialization complete');
});
</script>
</body>
</html>