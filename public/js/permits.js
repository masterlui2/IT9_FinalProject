document.addEventListener("DOMContentLoaded", function () {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", async function (e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            const modalElement = this.closest(".modal");
            const modalInstance = bootstrap.Modal.getInstance(modalElement);

            submitBtn.disabled = true;
            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span> Processing...`;

            try {
                const formData = new FormData(this);
                const response = await fetch(this.action, {
                    method: "POST",
                    headers: {
                        Accept: "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: formData,
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || "Submission failed");
                }

                // Success handling
                alert("Request submitted successfully!");
                form.reset();

                if (modalInstance) {
                    modalInstance.hide();
                }

                // Load requests table if View Requests modal exists
                if (document.getElementById("requestsModal")) {
                    await loadRequestsTable();

                    // Optionally show the requests modal after submission
                    // const requestsModal = new bootstrap.Modal(document.getElementById('requestsModal'));
                    // requestsModal.show();
                }
            } catch (error) {
                console.error("Error:", error);
                alert(error.message || "An error occurred during submission");
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    });

    // Improved function to load the requests table
    async function loadRequestsTable() {
        try {
            const tbody = document.getElementById("requestsTableBody");
            if (!tbody) return;

            tbody.innerHTML =
                '<tr><td colspan="6" class="text-center">Loading requests...</td></tr>';

            const response = await fetch("/my-permit-requests"); // Ensure this route exists
            if (!response.ok) {
                throw new Error("Failed to fetch requests");
            }

            const data = await response.json();
            tbody.innerHTML = "";

            if (data.length === 0) {
                tbody.innerHTML =
                    '<tr><td colspan="6" class="text-center">No requests found.</td></tr>';
                return;
            }

            data.forEach((req, index) => {
                const row = document.createElement("tr");
                row.innerHTML = `
            <td>${index + 1}</td>
            <td>${req.full_name || req.business_name || "N/A"}</td>
            <td>${req.type || "N/A"}</td>
            <td>${req.date || new Date().toLocaleDateString()}</td>
            <td><span class="badge bg-${getStatusColor(req.status)}">${
                    req.status || "Pending"
                }</span></td>
            <td><button class="btn btn-sm btn-outline-secondary">View</button></td>
          `;
                tbody.appendChild(row);
            });
        } catch (err) {
            console.error("Failed to load requests:", err);
            const tbody = document.getElementById("requestsTableBody");
            if (tbody) {
                tbody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Error loading requests</td></tr>`;
            }
        }
    }

    // Helper function for status colors
    function getStatusColor(status) {
        switch (status?.toLowerCase()) {
            case "approved":
                return "success";
            case "rejected":
                return "danger";
            case "processing":
                return "warning";
            default:
                return "info";
        }
    }

    // Load requests when View Requests modal is shown
    const requestsModal = document.getElementById("requestsModal");
    if (requestsModal) {
        requestsModal.addEventListener("show.bs.modal", loadRequestsTable);
    }
});
