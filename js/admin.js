window.addEventListener("DOMContentLoaded",main);
function main(){
    const url = "../php/request.php/installation/";

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
        modalEl.querySelector(".modal-title").textContent = "Ajouter une installation";
        modal.show();
    });
    ajaxRequest('GET',url,addlignes);//on affiche 100 lignes au hazart
}

function addlignes(rows){
    tbody=document.getElementById("installations-body");
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
                <button class="btn btn-sm btn-outline-primary me-2" data-action="edit" data-id="${row.id}"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-outline-danger" data-action="delete" data-id="${row.id}"><i class="bi bi-trash"></i></button>
              </td>
            `;
        tr.getElementsByClassName('btn-outline-primary')[0].addEventListener("click",installupdate);
        tr.getElementsByClassName('btn-outline-danger')[0].addEventListener("click",installdelete)
        tbody.appendChild(tr);
    });
};
function affichetoast(toastEl,message, error = false){
    toastEl.classList.remove("bg-success", "bg-danger");
    toastEl.classList.add(error ? "bg-danger" : "bg-success");
    toastEl.querySelector(".toast-body").textContent = message;
    toast.show();
};