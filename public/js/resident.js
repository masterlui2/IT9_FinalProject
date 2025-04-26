document.addEventListener("DOMContentLoaded", function () {
    bindDeleteButtons();
    document.querySelectorAll(".delete-resident").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.stopPropagation();
            const residentId = this.getAttribute("data-id");

            if (confirm("Are you sure you want to delete this resident?")) {
                fetch(`/residents/${residentId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                })
                    .then((res) => res.json())
                    .then((data) => {
                        if (data.success) {
                            alert("Resident deleted successfully!");
                            location.reload();
                        } else {
                            alert("Failed to delete resident.");
                        }
                    });
            }
        });
    });
});

// Handle resident form submission
document
    .getElementById("residentForm")
    .addEventListener("submit", async function (e) {
        e.preventDefault();

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML =
            '<i class="bi bi-arrow-repeat spinner"></i> Saving...';
        submitBtn.disabled = true;

        try {
            const formData = {
                full_name: document.getElementById("fullName").value,
                gender: document.getElementById("gender").value,
                birthdate: document.getElementById("birthdate").value,
                household_id: document.getElementById("household").value,
                household_head_name: document.getElementById(
                    "household_head_name"
                ).value,
                relationship: document.getElementById("relationship").value,
                income_source: document.getElementById("income").value,
                contact: document.getElementById("contact").value,
                _token: document.querySelector('meta[name="csrf-token"]')
                    .content,
            };

            const response = await fetch("/residents", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": formData._token,
                },
                body: JSON.stringify(formData),
            });

            const result = await response.json();
            console.log("API Response:", result); // Debugging

            if (!response.ok) {
                throw new Error(result.message || "Failed to save resident");
            }

            // Handle both response formats
            const residentData = result.resident || result;

            // Format all data with proper fallbacks
            const formattedData = {
                id: residentData.id || "",
                full_name: residentData.full_name || "N/A",
                gender: residentData.gender || "N/A",
                birthdate: residentData.birthdate
                    ? residentData.birthdate.split("T")[0] ||
                      residentData.birthdate
                    : "N/A",
                household_id:
                    residentData.household_id ||
                    residentData.household?.id ||
                    "N/A",
                income_source: residentData.income_source || "-",
                contact: residentData.contact || "-",
            };

            // Create new row
            const newRow = `
        <tr class="clickable-row" data-resident-id="${formattedData.id}">
            <td>${formattedData.id}</td>
            <td><strong>${formattedData.full_name}</strong></td>
            <td>${formattedData.gender}</td>
            <td>${formattedData.birthdate}</td>
            <td>Household #${formattedData.household_id}</td>
            <td>${formattedData.income_source}</td>
            <td>${formattedData.contact}</td>
            <td>
                <button class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger delete-resident" data-id="${formattedData.id}">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </td>
        </tr>`;

            // Insert new row
            const tbody = document.querySelector("table tbody");
            if (!tbody) throw new Error("Table body not found");
            tbody.insertAdjacentHTML("afterbegin", newRow);

            // Close modal and cleanup
            bootstrap.Modal.getInstance(
                document.getElementById("addResidentModal")
            ).hide();
            this.reset();
            document.body.classList.remove("modal-open");
            const backdrop = document.querySelector(".modal-backdrop");
            if (backdrop) backdrop.remove();

            showAlert("Resident added successfully!", "success");
        } catch (error) {
            console.error("Error:", error);
            showAlert(error.message || "Error saving resident", "danger");
        } finally {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        }
    });

// Row click handler
document.querySelectorAll(".clickable-row").forEach((row) => {
    row.addEventListener("click", function (e) {
        if (e.target.closest(".btn")) return;
        const residentId = this.getAttribute("data-resident-id");
        loadResidentDetails(residentId);
        new bootstrap.Modal(
            document.getElementById("residentDetailsModal")
        ).show();
    });
});

// Household change handler
document.getElementById("household").addEventListener("change", function () {
    const householdId = this.value;
    const householdHeadSelect = document.getElementById("household_head");
    householdHeadSelect.innerHTML =
        '<option value="" disabled selected>Select Head</option>';

    if (!householdId) return;

    fetch(`/households/${householdId}/heads`)
        .then((response) => response.json())
        .then((data) => {
            data.forEach((head) => {
                const option = document.createElement("option");
                option.value = head.id;
                option.textContent = head.full_name;
                householdHeadSelect.appendChild(option);
            });
        })
        .catch((error) => {
            console.error("Error fetching household heads:", error);
        });
});

// Add Member button handler
document.getElementById("addMemberBtn")?.addEventListener("click", function () {
    const householdId = document.getElementById(
        "detail-household-id"
    )?.textContent;
    if (householdId) {
        const householdSelect = document.getElementById("household");
        householdSelect.value = householdId;
        householdSelect.disabled = true;
        bootstrap.Modal.getInstance(
            document.getElementById("residentDetailsModal")
        ).hide();
        new bootstrap.Modal(document.getElementById("addResidentModal")).show();
    } else {
        showAlert("Please select a household first", "warning");
    }
});

// Load resident details
async function loadResidentDetails(residentId) {
    // Set all fields to loading state
    const detailFields = [
        "name",
        "gender",
        "birthdate",
        "contact",
        "income",
        "household-id",
        "address",
        "household-head",
        "members",
    ];
    detailFields.forEach((field) => {
        const el = document.getElementById(`detail-${field}`);
        if (el) el.textContent = "Loading...";
    });

    try {
        const response = await fetch(`/api/residents/${residentId}`); // Note: /api/ prefix
        if (!response.ok)
            throw new Error(`HTTP error! status: ${response.status}`);

        const data = await response.json();
        console.log("Resident Data:", data); // Debugging

        // Resident Info
        document.getElementById("detail-name").textContent =
            data.full_name || "N/A";
        document.getElementById("detail-gender").textContent =
            data.gender || "N/A";
        document.getElementById("detail-birthdate").textContent = data.birthdate
            ? new Date(data.birthdate).toLocaleDateString()
            : "N/A";
        document.getElementById("detail-contact").textContent =
            data.contact || "-";
        document.getElementById("detail-income").textContent =
            data.income_source || "-";

        // Household Info
        if (data.household) {
            document.getElementById("detail-household-id").textContent =
                data.household.id || "N/A";
            document.getElementById("detail-address").textContent =
                [
                    data.household.purok,
                    data.household.barangay,
                    data.household.city,
                ]
                    .filter(Boolean)
                    .join(", ") || "N/A";
            document.getElementById("detail-household-head").textContent =
                data.household.head_name || "N/A";

            // Members list
            const membersContainer = document.getElementById("detail-members");
            membersContainer.innerHTML = data.household.members?.length
                ? data.household.members
                      .map(
                          (member) => `
                    <tr>
                        <td>${member.full_name}</td>
                        <td>${member.relationship}</td>
                    </tr>
                `
                      )
                      .join("")
                : '<tr><td colspan="2">No members found</td></tr>';
        }
    } catch (error) {
        console.error("Error loading resident:", error);
        document.getElementById("detail-name").textContent =
            "Error loading data";
        showAlert("Failed to load resident details", "danger");
    }
}

// Alert helper function
function showAlert(message, type) {
    const existingAlert = document.querySelector(".alert");
    if (existingAlert) existingAlert.remove();

    const alertDiv = document.createElement("div");
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    alertDiv.style.zIndex = "1060";
    alertDiv.role = "alert";
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 5000);
}
