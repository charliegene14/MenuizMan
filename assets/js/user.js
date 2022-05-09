(function() {

    var form = document.getElementById("form-user");
    var error = document.getElementById("error-form");
    var hasError = false;

    function detectError(input, length) {
        if (input.value.length > length){

            input.previousElementSibling.style.display = "inline";
            hasError = true;
        } else {

            input.previousElementSibling.style.display = "none";
            hasError = false;
        }
    }

    document.getElementById("lastName").onkeydown =  function(e) {
        detectError(this, 20);
    }

    document.getElementById("firstName").onkeydown =  function(e) {
        detectError(this, 20);
    }

    document.getElementById("login").onkeydown =  function(e) {
        detectError(this, 16);
    }

    form.onsubmit = function(e) {

        let page = new URLSearchParams(window.location.href);

        if (
            document.getElementById("lastName").value.length < 1
            || document.getElementById("firstName").value.length < 1
            || document.getElementById("login").value.length < 1
            || (document.getElementById("password").value.length < 1 && !page.get("action") === "update")
        ) {
            hasError = true;
            document.getElementById("errglobal").style.display= "inline";
        }

        if (hasError) {
            e.preventDefault();
        }
    }

})()