<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style>
    body {
        margin: 0;
        background-color: rgb(248, 247, 247);
        font-family: sans-serif;
        overflow-x: hidden; /* ✅ Hides horizontal scroll */
        overflow-y: hidden!important;

    }

    .sidebar {
        background-color: #c82333;
        width: 280px!important;
        height: 100vh!important;
        position: fixed;
        left: 0;
        top: 0;
        padding: 0px 10px;
        overflow-y: hidden!important;
        display: flex;
        flex-direction: column;
    }

    .sidebar-content {
        flex: 1;
    }

    .sidebar .logo {
        max-width: 130%;
        border-radius: 8px;
        margin: -10px auto 10px auto;
    }

    .sidebar .nav-button {
        width: 100%;
        text-align: center;
        padding: 7px 10px;
        margin-bottom: 15px;
        border: none;
        border-radius: 10px;
        background-color: rgb(232, 192, 195);
        color: #212529;
        font-weight: 500;
        transition: 0.3s;
    }

    .sidebar .nav-button:hover {
        background-color: rgb(233, 134, 144);
    }

    .main-content {
        margin-left: 285px; /* same as sidebar width */
        padding: 30px;
        min-height: 150vh;
    }
    .nav-button.active {
        background-color: #fff;
        color: #c82333;
        font-weight: bold;
        border: 2px solid #fff;
    }
    
    /* Logout button styling */
    .logout-btn {
        width: 100%;
        text-align: center;
        padding: 10px;
        margin: 15px 0;
        border: none;
        border-radius: 10px;
        background-color:rgb(240, 117, 129);
        color: white;
        font-weight: 500;
        transition: 0.3s;
    }
    
    .logout-btn:hover {
        background-color: #bb2d3b;
    }
    
    /* Dashboard components horizontal scroll */
    .dashboard-container {
        overflow-x: auto;
        width: 100%;
    }
    
    .dashboard-components {
        min-width: 1200px; /* Adjust as needed */
    }
</style>

</head>
<body>

<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
        <div class="text-center mb-4 col-md-3 col-lg-2 sidebar">
            <div class="sidebar-content">
                <img src="{{ asset('images/logo.png') }}" alt="Barangay Logo" class="logo img-fluid">

                <button class="nav-button" onclick="loadContent('dashboard_content')">
                    <i class="fa-solid fa-chart-simple me-2"></i> Dashboard
                </button>
                <button class="nav-button" onclick="loadContent('residents')">
                    <i class="fa-solid fa-circle-user me-2"></i> Resident Info
                </button>
             
                <button class="nav-button" onclick="loadContent('permits')">
                    <i class="fa-solid fa-briefcase me-2"></i> Permits
                </button>
                <button class="nav-button" onclick="loadContent('incidents')">
                    <i class="fa-solid fa-person-burst me-2"></i> Incidents
                </button>
            </div>
            <!-- Add this form right before the logout button -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

           <!-- Change your logout button to this -->
<button class="logout-btn" data-bs-toggle="modal" data-bs-target="#logoutModal">
  <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
</button>
        </div>

        {{-- Main content --}}
        <div class="col-md-9 col-lg-10 main-content" id="mainContent">
            {{-- Loaded content will appear here --}}
            
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Global variables
    let dashboardStats = null;
    
    // 1. First define the chart rendering function
    async function renderDashboardCharts() {
        try {
            // Fetch all stats from server
            const response = await fetch('/dashboard-stats');
            
            if (!response.ok) {
                throw new Error(`Server returned ${response.status} status`);
            }
            
            dashboardStats = await response.json();
            console.log('Dashboard stats loaded:', dashboardStats);
            
            // Initialize charts
            const initCharts = () => {
                const charts = [
                    { 
                        id: 'chartPopulation', 
                        labels: ['Male', 'Female'], 
                        values: [dashboardStats.male_percentage, dashboardStats.female_percentage], 
                        colors: ['#005eff', '#66b3ff'] 
                    },
                    { 
                        id: 'chartResidential', 
                        labels: ['Occupied', 'Vacant'], 
                        values: [dashboardStats.occupied_percentage, dashboardStats.vacant_percentage], 
                        colors: ['#059b9a', '#2ed5da'] 
                    },
                    { 
                        id: 'chartCommercial', 
                        labels: ['Active', 'Inactive'], 
                        values: [dashboardStats.active_percentage, dashboardStats.inactive_percentage], 
                        colors: ['#0074e8', '#7ac6f6'] 
                    },
                    { 
                        id: 'chartTickets', 
                        labels: ['Closed', 'Open'], 
                        values: [dashboardStats.closed_percentage, dashboardStats.open_percentage], 
                        colors: ['#e85c00', '#ffa84c'] 
                    }
                ];

                // Initialize all charts
                charts.forEach(chart => {
                    const ctx = document.getElementById(chart.id);
                    if (ctx) {
                        if (ctx.chart) ctx.chart.destroy();
                        ctx.chart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: chart.labels,
                                datasets: [{
                                    data: chart.values,
                                    backgroundColor: chart.colors,
                                    cutout: '70%',
                                    borderWidth: 0
                                }]
                            },
                            options: {
                                plugins: { 
                                    legend: { display: false },
                                    tooltip: { enabled: true }
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    }
                });

                // Update all displayed values
                updateDisplayValues();
            };

            // Update all UI elements with current stats
            function updateDisplayValues() {
                // Stat cards
                document.getElementById('populationValue').textContent = dashboardStats.population.toLocaleString();
                document.getElementById('residentialValue').textContent = dashboardStats.residential.toLocaleString();
                document.getElementById('commercialValue').textContent = dashboardStats.commercial.toLocaleString();
                document.getElementById('incidentsValue').textContent = dashboardStats.incidents.toLocaleString();
                
                // Chart cards
                document.getElementById('populationChartValue').textContent = dashboardStats.population.toLocaleString();
                document.getElementById('residentialChartValue').textContent = dashboardStats.residential.toLocaleString();
                document.getElementById('commercialChartValue').textContent = dashboardStats.commercial.toLocaleString();
                document.getElementById('incidentsChartValue').textContent = dashboardStats.incidents.toLocaleString();
                
                // Percentages
                document.getElementById('populationPercentages').innerHTML = `
                    <span class="d-block">${dashboardStats.male_percentage}% Male</span>
                    <span class="d-block">${dashboardStats.female_percentage}% Female</span>
                `;
                document.getElementById('residentialPercentages').innerHTML = `
                    <span class="d-block">${dashboardStats.occupied_percentage}% Occupied</span>
                    <span class="d-block">${dashboardStats.vacant_percentage}% Vacant</span>
                `;
                document.getElementById('commercialPercentages').innerHTML = `
                    <span class="d-block">${dashboardStats.active_percentage}% Active</span>
                    <span class="d-block">${dashboardStats.inactive_percentage}% Inactive</span>
                `;
                document.getElementById('incidentsPercentages').innerHTML = `
                    <span class="d-block">${dashboardStats.closed_percentage}% Closed</span>
                    <span class="d-block">${dashboardStats.open_percentage}% Open</span>
                `;
            }

            // Add click event to residential card
            const residentialCard = document.getElementById('residentialCard');
            if (residentialCard) {
                residentialCard.style.cursor = 'pointer';
                residentialCard.addEventListener('click', async function() {
                    try {
                        // Increment on server
                        const response = await fetch('/dashboard-stats/increment-residential', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        
                        if (!response.ok) {
                            throw new Error('Failed to increment residential count');
                        }
                        
                        const updatedStats = await response.json();
                        console.log('Updated stats:', updatedStats);
                        
                        // Update local values
                        dashboardStats = updatedStats;
                        
                        // Update displays
                        updateDisplayValues();
                        
                        // Update residential chart
                        const ctx = document.getElementById('chartResidential');
                        if (ctx && ctx.chart) {
                            ctx.chart.data.datasets[0].data = [
                                updatedStats.occupied_percentage, 
                                updatedStats.vacant_percentage
                            ];
                            ctx.chart.update();
                        }
                        
                        // Visual feedback
                        this.style.transform = 'scale(0.98)';
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 200);
                        
                    } catch (error) {
                        console.error('Error incrementing residential count:', error);
                        alert('Failed to update residential count. Please try again.');
                    }
                });
            }

            // Initialize charts with small delay
            setTimeout(initCharts, 100);
            
        } catch (error) {
            console.error('Error rendering dashboard charts:', error);
            $('#mainContent').append(`
                <div class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Failed to load dashboard statistics: ${error.message}
                </div>
            `);
        }
    }

    // 2. Content loading function
    function loadContent(section) {
        $('#mainContent').html('<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-3x"></i><p class="mt-3">Loading...</p></div>');

        $('.nav-button').removeClass('active');
        $(`.nav-button[onclick*="${section}"]`).addClass('active');

        $.ajax({
            url: `/dashboard/view/${section}`,
            type: 'GET',
            success: function(response) {
                if (section === 'dashboard_content') {
                    response = `<div class="dashboard-container">${response}</div>`;
                }
                
                $('#mainContent').html(response);
                
                if (section === 'dashboard_content') {
                    renderDashboardCharts();
                }
            },
            error: function(xhr) {
                console.error("Error:", xhr);
                $('#mainContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Failed to load content. Please try again.
                    </div>
                `);
            }
        });
    }

    // 3. Initialize on page load
    $(document).ready(function() {
        // Ensure CSRF token is available for AJAX calls
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        loadContent('dashboard_content');
        $('.nav-button').first().addClass('active');
    });
</script>
    <!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="logoutModalLabel"><i class="fas fa-sign-out-alt me-2"></i>Confirm Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        Are you sure you want to log out?
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="document.getElementById('logout-form').submit();">Logout</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>