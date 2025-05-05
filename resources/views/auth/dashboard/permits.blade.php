<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Barangay Permits</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
      padding-top: 1rem;
    }
    .permit-card {
      border-radius: 0.625rem;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .permit-card:hover {
      transform: translateY(-5px);
    }
    .permit-header {
      background-color: #f0f0f0;
      padding: 1.25rem;
      border-top-left-radius: 0.625rem;
      border-top-right-radius: 0.625rem;
      border-bottom: 1px solid #dee2e6;
      position: relative;
    }
    .permit-title {
      font-weight: 600;
      font-size: 1.25rem;
      color: #1e40af;
      padding-left: 3rem;
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
      background-color: #28a745;
      color: white;
      padding: 0.125rem 0.5rem;
      border-radius: 0.25rem;
      font-size: 0.8rem;
      display: inline-block;
    }
    .fee {
      font-weight: 500;
      color: #333;
    }
    .btn-request {
      background-color: #2563eb;
      color: white;
      font-weight: 600;
    }
    .btn-request:hover {
      background-color: #1d4ed8;
    }
    .card-content {
      padding: 1.25rem;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }
    .card-actions {
      margin-top: auto;
    }
    .view-requests-btn {
      background-color: #28a745;
      color: white;
      font-weight: 600;
      padding: 0.5rem 1.5rem;
      border-radius: 0.5rem;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .view-requests-btn:hover {
      background-color: #218838;
    }
    .permit-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
      width: 100%;
    }
    @media (max-width: 992px) {
      .permit-container {
        grid-template-columns: repeat(2, 1fr);
      }
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
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="fs-2 fw-semibold text-gray-900 mb-0">Barangay Permits</h1>
      <button class="view-requests-btn">View Requests</button>
    </div>

    <div class="permit-container">
      <!-- Row 1 -->
      <!-- Barangay Clearance -->
      <div class="permit-card bg-white">
        <div class="permit-header">
          <img src="{{ asset('downloads/permits/approved.png') }}" alt="Clearance Icon" class="permit-icon" />
          <h3 class="permit-title">Barangay Clearance</h3>
        </div>
        <div class="card-content">
          <p class="mb-2"><span class="status-badge">Status: available</span></p>
          <p class="fee mb-4">Fee: ₽100</p>
          <div class="card-actions">
            <button class="btn btn-request w-100">Request</button>
          </div>
        </div>
      </div>
      
      <!-- Certificate of Residency -->
      <div class="permit-card bg-white">
        <div class="permit-header">
          <img src="{{ asset('downloads/permits/sms.png') }}" alt="Residency Icon" class="permit-icon" />
          <h3 class="permit-title">Certificate of Residency</h3>
        </div>
        <div class="card-content">
          <p class="mb-2"><span class="status-badge">Status: available</span></p>
          <p class="fee mb-4">Fee: ₽75</p>
          <div class="card-actions">
            <button class="btn btn-request w-100">Request</button>
          </div>
        </div>
      </div>
      
      <!-- Business Permit -->
      <div class="permit-card bg-white">
        <div class="permit-header">
          <img src="{{ asset('downloads/permits/bus.png') }}" alt="Business Icon" class="permit-icon" />
          <h3 class="permit-title">Business Permit</h3>
        </div>
        <div class="card-content">
          <p class="mb-2"><span class="status-badge">Status: available</span></p>
          <p class="fee mb-4">Fee: ₽100</p>
          <div class="card-actions">
            <button class="btn btn-request w-100">Request</button>
          </div>
        </div>
      </div>
      
      <!-- Row 2 -->
      <!-- Barangay ID -->
      <div class="permit-card bg-white">
        <div class="permit-header">
          <img src="{{ asset('downloads/permits/license.png') }}" alt="ID Icon" class="permit-icon" />
          <h3 class="permit-title">Barangay ID</h3>
        </div>
        <div class="card-content">
          <p class="mb-2"><span class="status-badge">Status: available</span></p>
          <p class="fee mb-4">Fee: ₽150</p>
          <div class="card-actions">
            <button class="btn btn-request w-100">Request</button>
          </div>
        </div>
      </div>
      
      <!-- Health Certificate -->
      <div class="permit-card bg-white">
        <div class="permit-header">
          <img src="{{ asset('downloads/permits/medical.png') }}" alt="Health Icon" class="permit-icon" />
          <h3 class="permit-title">Health Certificate</h3>
        </div>
        <div class="card-content">
          <p class="mb-2"><span class="status-badge">Status: available</span></p>
          <p class="fee mb-4">Fee: ₽120</p>
          <div class="card-actions">
            <button class="btn btn-request w-100">Request</button>
          </div>
        </div>
      </div>
      
      <!-- Construction Permit -->
      <div class="permit-card bg-white">
        <div class="permit-header">
          <img src="{{ asset('downloads/permits/certificate.png') }}" alt="Construction Icon" class="permit-icon" />
          <h3 class="permit-title">Construction Permit</h3>
        </div>
        <div class="card-content">
          <p class="mb-2"><span class="status-badge">Status: available</span></p>
          <p class="fee mb-4">Fee: ₽200</p>
          <div class="card-actions">
            <button class="btn btn-request w-100">Request</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>