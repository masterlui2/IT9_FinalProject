<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <style>
    body {
        margin: 0;
        background-color: rgb(255, 255, 255);
        font-family: sans-serif;
        overflow-x: hidden; /* ✅ Hides horizontal scroll */

    }

    .sidebar {
        background-color: #c82333;
        width: 280px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        padding: 0px 10px;
        overflow-y: auto;
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
</style>

</head>
<body>

<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
        <div class="text-center mb-4 col-md-3 col-lg-2 sidebar">
            <img src="{{ asset('images/logo.png') }}" alt="Barangay Logo" class="logo img-fluid">

            <button class="nav-button" onclick="loadContent('dashboard_content')">
                <i class="fa-solid fa-chart-simple me-2"></i> Dashboard
            </button>
            <button class="nav-button" onclick="loadContent('resident')">
                <i class="fa-solid fa-circle-user me-2"></i> Resident Info
            </button>
         
            <button class="nav-button" onclick="loadContent('documents')">
                <i class="fa-solid fa-file-invoice me-2"></i> Documents
            </button>
            <button class="nav-button" onclick="loadContent('permits')">
                <i class="fa-solid fa-briefcase me-2"></i> Permits
            </button>
            <button class="nav-button" onclick="loadContent('incidents')">
                <i class="fa-solid fa-person-burst me-2"></i> Incidents
            </button>
        </div>

        {{-- Main content --}}
        <div class="col-md-9 col-lg-10 main-content" id="mainContent">
            {{-- Loaded content will appear here --}}
            
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function renderDashboardCharts() {
        const genderCtx = document.getElementById('genderChart')?.getContext('2d');
        const ageCtx = document.getElementById('ageChart')?.getContext('2d');

        if (genderCtx) {
            new Chart(genderCtx, {
                type: 'pie',
                data: {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        data: [634, 600],
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
        }

        if (ageCtx) {
            new Chart(ageCtx, {
                type: 'bar',
                data: {
                    labels: ['0-17', '18-35', '36-59', '60+'],
                    datasets: [{
                        label: 'Number of Residents',
                        data: [300, 500, 280, 154],
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
        }
    }

    function loadContent(section) {
    $('#mainContent').html('<div class="text-center py-5">Loading...</div>');

    $.ajax({
        url: `/dashboard/view/${section}`,
        type: 'GET',
        success: function (response) {
            $('#mainContent').html(response);

            // ✅ Render charts if dashboard is loaded
            if (section === 'dashboard_content') {
                renderDashboardCharts();
            }

            // ✅ Highlight the active nav button
            $('.nav-button').removeClass('active');
            $(`.nav-button[onclick="loadContent('${section}')"]`).addClass('active');
        },
        error: function (xhr) {
            console.error("AJAX Load Error:", xhr);
            $('#mainContent').html('<div class="alert alert-danger">Failed to load content.</div>');
        }
    });
}

    $(document).ready(function () {
        // ✅ Load dashboard by default on first page load
        loadContent('dashboard_content');

        // ✅ Highlight Dashboard nav button by default
        $('.nav-button').removeClass('active');
        $('.nav-button').first().addClass('active');
    });
</script>





{{-- Bootstrap JS --}}
<!-- Add before closing </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
