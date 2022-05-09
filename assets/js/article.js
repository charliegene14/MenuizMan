(function() {

    var form = document.getElementById("add-replace");
    var id = new URLSearchParams(window.location.href).get("id");
    var err = document.getElementById("messerror");
    var messCopy = document.getElementById("mess-copied");
    var btnCopy = document.getElementById("copy-articleID");

    var btnRemove = document.querySelectorAll("i.remove");
    var btnAdd    = document.querySelectorAll("i.add");

    var phyValue  = document.getElementById("phy-value");
    var savValue  = document.getElementById("sav-value");
    var rebValue  = document.getElementById("reb-value");
    
    form.onsubmit = function(e) {
        e.preventDefault();
        let value = form.querySelector("input.form-control").value;
        
        $.post({
            url: './?p=article&action=show&id=' + id,
            data: {
                action: "ajax_add_replacement",
                addID: value
            },
            success: function(returns) {
                bool = JSON.parse(returns);

                if (bool) {
                    window.location.reload();
                } else {
                    err.style.display = "block";
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    btnRemove.forEach(function(btn) {
        
        btn.addEventListener("click", function() {

            if (btn.classList.contains("phy")) {
                phyValue.value = parseInt(phyValue.value) - 1; 
                if (phyValue.value <= 0) phyValue.value = 0;
            }  
            
            if (btn.classList.contains("sav")) {

                savValue.value = parseInt(savValue.value) - 1;
                if (savValue.value <= 0) savValue.value = 0;
            }

            if (btn.classList.contains("reb")) {

                rebValue.value = parseInt(rebValue.value) - 1;
                if (rebValue.value <= 0) rebValue.value = 0;
            }
        })

    })

    btnAdd.forEach(function(btn) {

        btn.addEventListener("click", function() {

            if (btn.classList.contains("phy")) 
                phyValue.value = parseInt(phyValue.value) + 1; 
        
            
            if (btn.classList.contains("sav"))
                savValue.value = parseInt(savValue.value) + 1;
    

            if (btn.classList.contains("reb"))
                rebValue.value = parseInt(rebValue.value) + 1;
    
        })
    })

    
    btnCopy.addEventListener("click",function(){
        sessionStorage.setItem("articleID",btnCopy.getAttribute("name"));
        messCopy.style.display = "inline";
    });
})()