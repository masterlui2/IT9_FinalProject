// Handle resident form submission
document
    .getElementById("residentForm")
    .addEventListener("submit", function (e) {
        e.preventDefault();

        // Get form values
        const fullName = document.getElementById("fullName").value;
        const gender = document.getElementById("gender").value;
        const birthdate = document.getElementById("birthdate").value;
        const household = document.getElementById("household").value;
        const relationship = document.getElementById("relationship").value;
        const income = document.getElementById("income").value;
        const contact = document.getElementById("contact").value;

        // Get table and insert new row
        const table = document.querySelector("table tbody");
        const newRow = document.createElement("tr");
        newRow.className = "clickable-row";
        newRow.setAttribute("data-bs-toggle", "modal");
        newRow.setAttribute("data-bs-target", "#residentDetailsModal");
        newRow.setAttribute("data-resident-id", table.rows.length + 1);

        const rowCount = table.rows.length + 1;

        newRow.innerHTML = `
            <td>${rowCount}</td>
            <td>${fullName} ${
            relationship === "Head"
                ? '<span class="badge bg-primary ms-2">Head</span>'
                : ""
        }</td>
            <td>${gender}</td>
            <td>${birthdate}</td>
            <td>Household #${household} - Purok ${household}</td>
            <td>${income}</td>
            <td>${contact}</td>
            <td>
                <button class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
            </td>
        `;

        table.appendChild(newRow);

        // Reset form
        document.getElementById("residentForm").reset();

        // Properly close the modal
        const modal = bootstrap.Modal.getInstance(
            document.getElementById("addResidentModal")
        );
        modal.hide();

        // Remove any lingering backdrop
        const backdrops = document.getElementsByClassName("modal-backdrop");
        for (let backdrop of backdrops) {
            backdrop.parentNode.removeChild(backdrop);
        }

        // Also remove the modal-open class from body if it exists
        document.body.classList.remove("modal-open");
    });

// Handle click on resident row to show details
