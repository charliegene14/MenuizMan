var deleteBtn = document.getElementsByClassName("fa-trash-can");
var updateBtn = document.getElementsByClassName("fa-square-arrow-up-right");


 // Subscribe "delete" buttons from Admin Home
for (let del of deleteBtn) {
    del.addEventListener("click",function(){
        username = del.getAttribute("name").replace("*"," ");
        confirmation = confirm("Êtes-vous certain de vouloir supprimer " + username);
        if(confirmation)
            window.location.search = "?p=user&action=delete&id=" + del.getAttribute("id");
    })
}


//Subscribe "update" buttons from Admin Home 
for (let upd of updateBtn) {
    upd.addEventListener("click",function(){
        window.location.search = "?p=user&action=update&id=" + upd.getAttribute("id");
    })
}

