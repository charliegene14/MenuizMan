var form  = document.getElementById("choice-form");
var toDoCard = document.getElementsByClassName("todo-action");

var tValues = ["2","3","4","5","6"];

if (form) {

    var submit = document.getElementById("choice-submit");
    var selectedValue = document.getElementById("newTask");

    /**
     * Subscribe submit button
     */
    submit.addEventListener("click", function() {
        
        if(tValues.includes(selectedValue.value)) {
            form.submit();
        } else {
            window.location.search = "?p=martoni";
            return;
        }
        
    })
}

var replaceInput = document.getElementById("articleID_replace");
var link         = document.getElementById("do-task-link");

if (replaceInput) {

    let origin = link.getAttribute("href");
    
    replaceInput.onkeyup = function(e) {
        link.setAttribute("href", origin + "&replaceID=" + this.value);
    }
}

if(toDoCard) {
    var pasteImg = document.getElementById("paste-img");
    if(pasteImg) {
        pasteImg.addEventListener("click",function(){
            if(sessionStorage.getItem("articleID")){
                document.getElementById("articleID_replace").value = sessionStorage.getItem("articleID");
                let origin = link.getAttribute("href");
                link.setAttribute("href", origin + "&replaceID=" + document.getElementById("articleID_replace").value);
            }
        })
    }
}