<!-- resources/views/auth/dashboard/dashboard_content.blade.php -->

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Barangay Resident Demographics</h2>
            <p class="text-muted">Overview of the current population and household data</p>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Residents</h5>
                    <h2 class="card-text">1,234</h2> <!-- Replace with dynamic data -->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5 class="card-title">Male</h5>
                    <h2 class="card-text">634</h2> <!-- Replace with dynamic data -->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <h5 class="card-title">Female</h5>
                    <h2 class="card-text">600</h2> <!-- Replace with dynamic data -->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-dark shadow">
                <div class="card-body">
                    <h5 class="card-title">Households</h5>
                    <h2 class="card-text">321</h2> <!-- Replace with dynamic data -->
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-white fw-bold">
                    Gender Distribution
                </div>
                <div class="card-body">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-white fw-bold">
                    Age Group Breakdown
                </div>
                <div class="card-body">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gender Distribution
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'pie',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [634, 600], // Replace with dynamic data
                backgroundColor: ['#0d6efd', '#dc3545'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Age Group Breakdown
    const ageCtx = document.getElementById('ageChart').getContext('2d');
    new Chart(ageCtx, {
        type: 'bar',
        data: {
            labels: ['0-17', '18-35', '36-59', '60+'],
            datasets: [{
                label: 'Number of Residents',
                data: [300, 500, 280, 154], // Replace with dynamic data
                backgroundColor: '#198754'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
