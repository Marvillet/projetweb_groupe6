window.addEventListener("DOMContentLoaded",main);
function main(){
    const currentPage = window.location.pathname.split("/").pop();

    document.querySelectorAll(".navbar-nav .nav-link").forEach(link => {
        const linkPage = link.getAttribute("href").split("/").pop();
        if (linkPage === currentPage) {
            link.classList.add("active");
        }
    });

    const url = "../php/request.php/admin";

    const tbody = document.getElementById("installations-body");
    const modalEl = document.getElementById("installationModal");
    const form = document.getElementById("installation-form");
    const toastEl = document.getElementById("toast-msg");

    //fenetre pop qui demande les infos
    const modal = new bootstrap.Modal(modalEl);
    //petite notif en bas de l'image
    const toast = new bootstrap.Toast(toastEl);

    document.getElementById("btn-add").addEventListener("click", () => {
        form.reset();//on vide le formulaire
        document.getElementById("install-id").value = "";
        //$('#installateur-name').val(null).trigger('change');
        modalEl.querySelector(".modal-title").textContent = "Ajouter une installation";
        modal.show();
    });

    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const data = {
            id: document.getElementById("install-id").value,
            //installateur: document.getElementById("installateur-name").value,
            puissance: parseFloat(document.getElementById("install-power").value),
            annee: parseInt(document.getElementById("install-year").value),
            mois: document.getElementById("install-mois").value,
            commune: document.getElementById("install-commune").value,
            codePostal: document.getElementById("codePostal").value,
            lat: parseFloat(document.getElementById("install-lat").value),
            lon: parseFloat(document.getElementById("install-lon").value),
            nbPanneaux: parseInt(document.getElementById("nbPanneaux").value),
            marquePanneaux: document.getElementById("install-marquePanneaux").value,
            modelePanneaux: document.getElementById("install-modelePanneaux").value,
            nbOnduleur: parseInt(document.getElementById("nbOnduleur").value),
            marqueOnduleur: document.getElementById("install-marqueOnduleur").value,
            modeleOnduleur: document.getElementById("install-modeleOnduleur").value,
            surface: parseFloat(document.getElementById("install-surface").value),
            pente: document.getElementById("install-Pente").value,
            orientation: document.getElementById("install-orientation").value,
            orientationOpt: document.getElementById("install-orientationOpt").value,
            pvgis: parseInt(document.getElementById("install-pvgis").value)
        };
        // Appel AJAX personnalisé
        ajaxRequest("POST", "../php/request.php/admin"+data, (response) => {

            // afficher toast succès
            affichetoast("Installation ajoutée avec succès");

            // Réinitialiser et fermer le modal
            form.reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById("installationModal"));
            modal.hide();
        });
    });
    ajaxRequest('GET',url,addlignes);//on affiche les 100 dernières installations installées
}

function addlignes(rows){
    let tbody=document.getElementById("resultat");
    tbody.innerHTML = "";
    rows.forEach((row) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
              <td>${row['id']}</td>
              <td>${row['nb_panneaux']}</td>
              <td>${row['puissance_crete']}</td>
              <td>${row['nom_standard']}</td>
              <td>${row['mois_installation']} / ${row['an_installation']}</td>
              <td class="text-center">
                <a href="modif.php?id=${row['id']}" class="btn btn-sm btn-outline-primary me-2" title='Modification' ><i class="bi bi-pencil"></i></a>
                <button class="btn btn-sm btn-outline-danger" data-action="delete" data-id="${row['id']}"><i class="bi bi-trash"></i></button>
                <a href="../front/detail.html?id=${row['id']}" class='btn btn-outline-primary btn-sm' title='Voir le détail'><i class="bi bi-search"></i></a>
              </td>
            `;
        tr.getElementsByClassName('btn-outline-primary')[0].addEventListener("click",installupdate);
        tr.getElementsByClassName('btn-outline-danger')[0].addEventListener("click",installdelete);
        tbody.appendChild(tr);
    });
    window.displayPage(1)
}
function affichetoast(toastEl,message, error = false){
    toastEl.classList.remove("bg-success", "bg-danger");
    toastEl.classList.add(error ? "bg-danger" : "bg-success");
    toastEl.querySelector(".toast-body").textContent = message;
    toast.show();
}
function installupdate(event){
    console.log(event.target.dataset.id);
    console.log("update");
    //id de l'installation
    let id=event.target.dataset.id;

}

function installdelete(event) {
    console.log("delete");

    //si l'utilisateur clique sur l'icone, event est alors l'icone elle même et ne possède donc pas d'id
    const button = event.target.closest('button');
    if (!button) return;

    const id = button.dataset.id;
    console.log("ID supprimé :", id);

    ajaxRequest('DELETE', '../php/request.php/admin/' + id, addlignes);
}