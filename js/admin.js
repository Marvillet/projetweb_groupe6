(() => {
    const API_URL = "../php/installation_controleur.php";

    // DOM elements
    const tbody = document.getElementById("installations-body");
    const modalEl = document.getElementById("installationModal");
    const modal = new bootstrap.Modal(modalEl);
    const form = document.getElementById("installation-form");
    const toastEl = document.getElementById("toast-msg");
    const toast = new bootstrap.Toast(toastEl);

    // Populate list
    const fetchInstallations = async () => {
        try {
            const res = await fetch(API_URL);
            if (!res.ok) throw new Error("Erreur lors du chargement");
            const data = await res.json();
            renderRows(data);
        } catch (err) {
            showToast(err.message, true);
        }
    };

    const renderRows = (rows) => {
        tbody.innerHTML = "";
        rows.forEach((row) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
              <td>${row.id}</td>
              <td>${row.nom}</td>
              <td>${row.puissance}</td>
              <td>${row.commune}</td>
              <td>${row.annee}</td>
              <td class="text-center">
                <button class="btn btn-sm btn-outline-primary me-2" data-action="edit" data-id="${row.id}"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-outline-danger" data-action="delete" data-id="${row.id}"><i class="bi bi-trash"></i></button>
              </td>
            `;
            tbody.appendChild(tr);
        });
    };

    // Toast helper
    const showToast = (message, error = false) => {
        toastEl.classList.remove("bg-success", "bg-danger");
        toastEl.classList.add(error ? "bg-danger" : "bg-success");
        toastEl.querySelector(".toast-body").textContent = message;
        toast.show();
    };

    // Open modal for create
    document.getElementById("btn-add").addEventListener("click", () => {
        form.reset();
        document.getElementById("install-id").value = "";
        modalEl.querySelector(".modal-title").textContent = "Ajouter une installation";
        modal.show();
    });

    // Delegate edit/delete buttons
    tbody.addEventListener("click", async (e) => {
        const btn = e.target.closest("button");
        if (!btn) return;
        const id = btn.dataset.id;
        if (btn.dataset.action === "edit") {
            // Fetch single installation then open modal
            try {
                const res = await fetch(`${API_URL}?id=${id}`);
                if (!res.ok) throw new Error("Impossible de charger la fiche");
                const inst = await res.json();
                // Populate form
                document.getElementById("install-id").value = inst.id;
                document.getElementById("install-name").value = inst.nom;
                document.getElementById("install-power").value = inst.puissance;
                document.getElementById("install-year").value = inst.annee;
                document.getElementById("install-commune").value = inst.commune;
                document.getElementById("install-lat").value = inst.lat || "";
                document.getElementById("install-lng").value = inst.lng || "";
                modalEl.querySelector(".modal-title").textContent = "Modifier l'installation";
                modal.show();
            } catch (err) {
                showToast(err.message, true);
            }
        } else if (btn.dataset.action === "delete") {
            if (confirm("Supprimer définitivement cette installation ?")) {
                try {
                    const res = await fetch(`${API_URL}?id=${id}`, { method: "DELETE" });
                    if (!res.ok) throw new Error("Échec de la suppression");
                    showToast("Installation supprimée");
                    fetchInstallations();
                } catch (err) {
                    showToast(err.message, true);
                }
            }
        }
    });

    // Form submit (create/update)
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (!form.checkValidity()) {
            form.classList.add("was-validated");
            return;
        }
        const id = document.getElementById("install-id").value;
        const payload = {
            nom: document.getElementById("install-name").value.trim(),
            puissance: parseFloat(document.getElementById("install-power").value),
            annee: parseInt(document.getElementById("install-year").value, 10),
            commune: document.getElementById("install-commune").value.trim(),
            lat: document.getElementById("install-lat").value || null,
            lng: document.getElementById("install-lng").value || null,
        };
        try {
            const res = await fetch(id ? `${API_URL}?id=${id}` : API_URL, {
                method: id ? "PUT" : "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload),
            });
            if (!res.ok) throw new Error("Erreur lors de l'enregistrement");
            modal.hide();
            showToast(id ? "Installation mise à jour" : "Installation ajoutée");
            fetchInstallations();
        } catch (err) {
            showToast(err.message, true);
        }
    });

    // Initial load
    fetchInstallations();
})();