<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- resources/views/auth/dashboard/dashboard_content.blade.php -->
<div class="container-fluid py-4 dashboard-container">
    <div class="row mb-3">
        <div class="col">
            <h4 class="fw-bold">Barangay Dashboard</h4>
        </div>
    </div>
    <!-- Wide but short image section -->
    <div class="row mt-4">
        <div class="col">
            <img src="{{ asset('downloads/permits/image.png') }}" alt="Dashboard Banner" class="img-fluid custom-banner">
        </div>
    </div>
    
   <!-- Statistic Cards -->
<div class="row g-4 mt-3">
    <!-- Population -->
    <div class="col-xl-3 col-md-6">
        <div class="card stats-card card-hover-primary shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted text-uppercase fw-bold small">Statistics</div>
                        <div class="stat-value text-primary" id="populationValue">11,200</div>
                        <div class="stat-change text-success">
                            <i class="fas fa-arrow-up trend-icon"></i>
                            <span>1% increase</span>
                        </div>
                    </div>
                    <div class="icon-circle">
                        <i class="fas fa-chart-bar text-primary"></i>
                    </div>
                </div>
                <div class="progress mt-4">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                </div>
                <div class="mini-chart">
                    <div class="chart-bar" style="height: 50%"></div>
                    <div class="chart-bar" style="height: 65%"></div>
                    <div class="chart-bar" style="height: 75%"></div>
                    <div class="chart-bar" style="height: 60%"></div>
                    <div class="chart-bar" style="height: 70%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Residential -->
    <div class="col-xl-3 col-md-6">
        <div class="card stats-card card-hover-success shadow-sm" id="residentialCard">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted text-uppercase fw-bold small">Residential</div>
                        <div class="stat-value text-success" id="residentialValue">2,240</div>
                        <div class="stat-change text-success">
                            <i class="fas fa-arrow-up trend-icon"></i>
                            <span>1% increase</span>
                        </div>
                    </div>
                    <div class="icon-circle">
                        <i class="fas fa-house-user text-success"></i>
                    </div>
                </div>
                <div class="progress mt-4">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                </div>
                <div class="mini-chart">
                    <div class="chart-bar" style="height: 60%"></div>
                    <div class="chart-bar" style="height: 75%"></div>
                    <div class="chart-bar" style="height: 85%"></div>
                    <div class="chart-bar" style="height: 80%"></div>
                    <div class="chart-bar" style="height: 70%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Commercial -->
    <div class="col-xl-3 col-md-6">
        <div class="card stats-card card-hover-info shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted text-uppercase fw-bold small">Commercial</div>
                        <div class="stat-value text-info" id="commercialValue">3,424</div>
                        <div class="stat-change text-success">
                            <i class="fas fa-arrow-up trend-icon"></i>
                            <span>1% increase</span>
                        </div>
                    </div>
                    <div class="icon-circle">
                        <i class="fas fa-store text-info"></i>
                    </div>
                </div>
                <div class="progress mt-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 65%"></div>
                </div>
                <div class="mini-chart">
                    <div class="chart-bar" style="height: 45%"></div>
                    <div class="chart-bar" style="height: 55%"></div>
                    <div class="chart-bar" style="height: 65%"></div>
                    <div class="chart-bar" style="height: 50%"></div>
                    <div class="chart-bar" style="height: 60%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Incidents -->
    <div class="col-xl-3 col-md-6">
        <div class="card stats-card card-hover-danger shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted text-uppercase fw-bold small">Incidents</div>
                        <div class="stat-value text-danger" id="incidentsValue">97</div>
                        <div class="stat-change text-success">
                            <i class="fas fa-arrow-up trend-icon"></i>
                            <span>1% increase</span>
                        </div>
                    </div>
                    <div class="icon-circle">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    </div>
                </div>
                <div class="progress mt-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 55%"></div>
                </div>
                <div class="mini-chart">
                    <div class="chart-bar" style="height: 35%"></div>
                    <div class="chart-bar" style="height: 45%"></div>
                    <div class="chart-bar" style="height: 55%"></div>
                    <div class="chart-bar" style="height: 40%"></div>
                    <div class="chart-bar" style="height: 50%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Donut Charts -->
<div class="row g-4 mt-4">
    <!-- Population Chart -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0 p-3">
            <div class="text-center">
                <p class="fw-bold mb-1" id="populationChartValue">11,200</p>
                <small class="text-muted">Population</small>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <div style="width: 120px; height: 120px;">
                    <canvas id="chartPopulation"></canvas>
                </div>
            </div>
            <div class="mt-3 text-center" id="populationPercentages">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Residential Chart -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0 p-3">
            <div class="text-center">
                <p class="fw-bold mb-1" id="residentialChartValue">2,240</p>
                <small class="text-muted">Residential Areas</small>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <div style="width: 120px; height: 120px;">
                    <canvas id="chartResidential"></canvas>
                </div>
            </div>
            <div class="mt-3 text-center" id="residentialPercentages">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Commercial Chart -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0 p-3">
            <div class="text-center">
                <p class="fw-bold mb-1" id="commercialChartValue">3,424</p>
                <small class="text-muted">Establishments</small>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <div style="width: 120px; height: 120px;">
                    <canvas id="chartCommercial"></canvas>
                </div>
            </div>
            <div class="mt-3 text-center" id="commercialPercentages">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Tickets Chart -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0 p-3">
            <div class="text-center">
                <p class="fw-bold mb-1" id="incidentsChartValue">97</p>
                <small class="text-muted">Total Incidents</small>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <div style="width: 120px; height: 120px;">
                    <canvas id="chartTickets"></canvas>
                </div>
            </div>
            <div class="mt-3 text-center" id="incidentsPercentages">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>
<style>
.dashboard-container {
    height: 90vh;
    overflow-y: scroll; /* Changed to scroll to always show scroll space */
    overflow-x: hidden;
    padding-right: 25px;
    
    /* Hide scrollbar but keep functionality */
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE/Edge */
}
.card-hover-danger:hover {
    background: linear-gradient(45deg, #e74a3b, #b92c1f);
}

.stats-card:hover .text-danger {
    color: white !important;
}

/* WebKit scrollbar hide */
.dashboard-container::-webkit-scrollbar {
    display: none;
    width: 0;
    height: 0;
}

.row, .col, .card, .custom-banner {
    max-width: 120%; /* Changed from 130% to prevent overflow */
    overflow-x: hidden;
}

.stats-card {
    border: none;
    border-radius: 15px;
    transition: all 0.3s ease;
    overflow: hidden;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, .1);
}

.card-hover-primary:hover {
    background: linear-gradient(45deg, #4e73df, #224abe);
}

.card-hover-success:hover {
    background: linear-gradient(45deg, #1cc88a, #169a6b);
}

.card-hover-info:hover {
    background: linear-gradient(45deg, #36b9cc, #258391);
}

.card-hover-warning:hover {
    background: linear-gradient(45deg, #f6c23e, #dda20a);
}

.stats-card:hover .text-primary,
.stats-card:hover .text-success,
.stats-card:hover .text-info,
.stats-card:hover .text-warning,
.stats-card:hover .text-muted,
.stats-card:hover .card-title {
    color: white !important;
}

.icon-circle {
    height: 60px;
    width: 60px;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    background: rgba(0, 0, 0, .05);
    transition: all 0.3s ease;
}

.stats-card:hover .icon-circle {
    background: rgba(255, 255, 255, .2);
}

.stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 10px 0;
}

.progress {
    height: 8px;
    border-radius: 4px;
    background: rgba(0, 0, 0, .05);
}

.progress-bar {
    border-radius: 4px;
}

.stat-change {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.9rem;
}

.trend-icon {
    font-size: 0.8rem;
}

.mini-chart {
    height: 50px;
    margin-top: 10px;
    display: flex;
    align-items: flex-end;
    gap: 3px;
}

.chart-bar {
    flex: 1;
    background: rgba(0, 0, 0, .05);
    border-radius: 3px 3px 0 0;
    transition: all 0.3s ease;
}

.stats-card:hover .chart-bar {
    background: rgba(41, 40, 40, 0.2);
}

/* Donut chart cards */
.card.shadow-sm {
    border-radius: 15px;
    transition: all 0.3s ease;
}

.card.shadow-sm:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, .1) !important;
}

.custom-banner {
    width: 100%;
    max-height: 240px;
    object-fit: cover;
    border-radius: 10px;
    object-position: 0 -20px;
    margin-bottom: 15px;
}
</style>
