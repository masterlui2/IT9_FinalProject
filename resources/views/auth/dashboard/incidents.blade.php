<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Incident Reports</h4>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalIncidentForm">
            <i class="fas fa-plus"></i> New Report
        </button>
    </div>

    <!-- Incident Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Case #</th>
                            <th>Type</th>
                            <th>Reported By</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($incidents as $incident)
                        <tr>
                            <td>{{ $incident->case_number }}</td>
                            <td>{{ $incident->type }}</td>
                            <td>{{ $incident->reported_by }}</td>
                            <td>{{ $incident->date }}</td>
                            <td>
                                <span class="badge 
                                    {{ $incident->status === 'Resolved' ? 'bg-success' : 
                                       ($incident->status === 'Investigation' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $incident->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <button class="btn btn-link btn-sm text-primary view-incident" data-id="{{ $incident->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-link btn-sm text-info edit-incident" data-id="{{ $incident->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Incident Form Modal -->
    <div class="modal fade" id="modalIncidentForm" tabindex="-1" aria-labelledby="incidentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="incidentForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="incidentModalLabel">New Incident Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Incident Type</label>
                        <select class="form-select form-select-sm" name="type" required>
                            <option selected disabled>Select Type</option>
                            <option>Theft</option>
                            <option>Assault</option>
                            <option>Property Damage</option>
                            <option>Noise Complaint</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Reporter Name</label>
                        <input type="text" class="form-control form-control-sm" name="reported_by" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control form-control-sm" name="date" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <textarea class="form-control form-control-sm" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Save Report</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Incident Modal -->
    <div class="modal fade" id="modalViewIncident" tabindex="-1" aria-labelledby="viewIncidentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Incident Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="incidentDetails">
                        <!-- Details will be loaded dynamically -->
                        <p class="text-muted text-center">Loading...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Section -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // View button
    document.querySelectorAll('.view-incident').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            // Replace with AJAX to fetch real data
            document.getElementById('incidentDetails').innerHTML = `
                <h6 class="fw-bold mb-1">Case #BRG-${id}</h6>
                <span class="badge bg-warning">Under Investigation</span>
                <dl class="row mt-3">
                    <dt class="col-sm-4">Type:</dt><dd class="col-sm-8">Theft</dd>
                    <dt class="col-sm-4">Reported By:</dt><dd class="col-sm-8">Juan Dela Cruz</dd>
                    <dt class="col-sm-4">Date:</dt><dd class="col-sm-8">May 15, 2023</dd>
                    <dt class="col-sm-4">Location:</dt><dd class="col-sm-8">Purok 5</dd>
                    <dt class="col-sm-4">Description:</dt><dd class="col-sm-8">Bicycle stolen from front yard</dd>
                </dl>`;
            new bootstrap.Modal(document.getElementById('modalViewIncident')).show();
        });
    });

    // Edit button (reuses Add modal)
    document.querySelectorAll('.edit-incident').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            // Preload logic if needed here
            new bootstrap.Modal(document.getElementById('modalIncidentForm')).show();
        });
    });
});

</script>
