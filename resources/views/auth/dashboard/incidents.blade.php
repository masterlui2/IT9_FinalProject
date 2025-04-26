<div class="container-fluid p-0">
    <!-- Header with Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">Incident Reports</h1>
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addIncidentModal">
            <i class="fas fa-plus"></i> New Report
        </button>
    </div>

    <!-- Incidents Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Case #</th>
                            <th>Type</th>
                            <th>Reported By</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>BRG-0015</td>
                            <td>Theft</td>
                            <td>Juan Dela Cruz</td>
                            <td>May 15, 2023</td>
                            <td><span class="badge badge-warning">Investigation</span></td>
                            <td class="text-right">
                                <button class="btn btn-sm btn-link p-0 view-incident" data-id="15">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-link p-0 edit-incident ml-2" data-id="15">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>BRG-0014</td>
                            <td>Noise</td>
                            <td>Maria Santos</td>
                            <td>May 14, 2023</td>
                            <td><span class="badge badge-success">Resolved</span></td>
                            <td class="text-right">
                                <button class="btn btn-sm btn-link p-0 view-incident" data-id="14">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-link p-0 edit-incident ml-2" data-id="14">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>BRG-0013</td>
                            <td>Damage</td>
                            <td>Roberto Garcia</td>
                            <td>May 12, 2023</td>
                            <td><span class="badge badge-danger">Closed</span></td>
                            <td class="text-right">
                                <button class="btn btn-sm btn-link p-0 view-incident" data-id="13">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-link p-0 edit-incident ml-2" data-id="13">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Incident Modal -->
    <div class="modal fade" id="addIncidentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Incident Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Incident Type</label>
                            <select class="form-control form-control-sm">
                                <option>Theft</option>
                                <option>Assault</option>
                                <option>Property Damage</option>
                                <option>Noise Complaint</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Reporter Name</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control form-control-sm" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-primary">Save Report</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Incident Modal -->
    <div class="modal fade" id="viewIncidentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Incident Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6 class="font-weight-bold mb-1">Case #BRG-0015</h6>
                        <span class="badge badge-warning">Under Investigation</span>
                    </div>
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Type:</dt>
                        <dd class="col-sm-9">Theft</dd>
                        
                        <dt class="col-sm-3">Reported By:</dt>
                        <dd class="col-sm-9">Juan Dela Cruz</dd>
                        
                        <dt class="col-sm-3">Date:</dt>
                        <dd class="col-sm-9">May 15, 2023 14:30</dd>
                        
                        <dt class="col-sm-3">Location:</dt>
                        <dd class="col-sm-9">Purok 5, near basketball court</dd>
                        
                        <dt class="col-sm-3">Description:</dt>
                        <dd class="col-sm-9">Bicycle stolen from front yard between 10AM-2PM. Red Mountain Bike with black handlebars.</dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // View incident button click
    $('.view-incident').click(function() {
        $('#viewIncidentModal').modal('show');
    });
    
    // Edit incident button click
    $('.edit-incident').click(function() {
        // In a real app, you would load data here
        $('#addIncidentModal').modal('show');
    });
});
</script>