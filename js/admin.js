window.addEventListener("DOMContentLoaded",main);
let toast;
function main(){
    const currentPage = window.location.pathname.split("/").pop();

    document.querySelectorAll(".navbar-nav .nav-link").forEach(link => {
        const linkPage = link.getAttribute("href").split("/").pop();
        if (linkPage === currentPage) {
            link.classList.add("active");
        }
    });

    const urlrecherche = "../php/request.php/admin";

    const tbody = document.getElementById("installations-body");
    const modalEl = document.getElementById("installationModal");
    const form = document.getElementById("installation-form");
    const toastEl = document.getElementById("toast-msg");

    //fenetre pop qui demande les infos
    const modal = new bootstrap.Modal(modalEl);
    //petite notif en bas de l'image
    toast = new bootstrap.Toast(toastEl);
    document.getElementById("choix").addEventListener("change",(event)=>{
        console.log(event.target)
        modalEl.querySelector(".modal-title").textContent = "Ajouter "+event.target.selected;
    })
    document.getElementById("btn-add").addEventListener("click", () => {
        form.reset();//on vide le formulaire
        modalEl.querySelector(".modal-title").textContent = "Ajouter une instance";
        modal.show();
    });

    form.addEventListener("submit", (event) => {
        event.preventDefault();
        let choix = document.getElementById("choix");
        let denomination = document.getElementById("denomination").value;
        let url2 = "";
        let msg = "";
        let data="";
        switch (parseInt(choix.value)) {
            case 1:
                msg = "Installateur";
                url2 = "../php/request.php/installateur";
                data="installateur";
                //console.log("test request 1 " + url2);
                break;
            case 2:
                msg = "Modele de Panneau";
                url2 = "../php/request.php/panneau/modele";
                data="modele";
                break;
            case 3:
                msg = "Marque de Panneau";
                url2 = "../php/request.php/panneau/marque";
                data="marque";
                break;
            case 4:
                msg = "Modele de Onduleur";
                url2 = "../php/request.php/onduleur/modele";
                data="modele";
                break;
            case 5:
                msg = "Modele de Onduleur";
                url2 = "../php/request.php/onduleur/marque";
                data="marque";
                break;
        }
        //console.log("test request 2 " + url2);
        // Appel AJAX personnalisé
        ajaxRequest2("POST", url2, (json, code) => { add(json,code,msg,toastEl)}, data+"=" + denomination);
    })
    ajaxRequest('GET',urlrecherche,addlignes);//on affiche les 100 dernières installations installées
}
function add(json,code,msg,toastEl){
    if(code===200 || code===201){
        affichetoast(toastEl,msg+" reussie")
        ajaxRequest('GET',"../php/request.php/admin",addlignes);//on affiche les 100 dernières installations installées
    }
    else{
        affichetoast(toastEl,"Echec de l'ajoue de "+msg, true)
    }
    const modal = bootstrap.Modal.getInstance(document.getElementById("installationModal"));
    modal.hide();
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