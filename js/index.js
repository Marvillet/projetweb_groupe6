const rowsPerPage = 7;
const table = document.getElementById("data-table");
const tbody = table.querySelector("tbody");
const pagination = document.getElementById("pagination");
const rows = Array.from(tbody.querySelectorAll("tr"));

let currentPage = 1;
function displayPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    rows.forEach((row, index) => {
    row.style.display = (index >= start && index < end) ? "" : "none";
});
    // Update pagination
    pagination.innerHTML = "";
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement("li");
        li.className = `page-item${i === page ? " active" : ""}`;
        const btn = document.createElement("button");
        btn.className = "page-link";
        btn.textContent = i;
        btn.onclick = () => displayPage(i);
        li.appendChild(btn);
        pagination.appendChild(li);
    }
}

// Initialisation
displayPage(currentPage);
