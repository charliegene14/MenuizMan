(function() {

    var loginForm = document.querySelector("form");
    loginForm.style.position = "relative";

    var errorForm = document.createElement("p");
    errorForm.style.position = "absolute";
    errorForm.style.textAlign = "center";
    errorForm.style.width = "100%";
    errorForm.style.top = "-2rem";
    errorForm.style.color = "var(--bs-danger)";
    errorForm.innerText = "ID ou mot de passe incorrect";

    /**
     * Send login form with post method
     * @param {*} e 
     */
    loginForm.onsubmit = function(e) {

        e.preventDefault();

        let login       = loginForm.querySelector("#id").value;
        let password    = loginForm.querySelector("#password").value;
        
        $.post({
            data: {
                action: "credentials_validation",
                login: login,
                password: password
            },
            url: "./",
            success: function(data) {

                if (data !== "1") {
                    loginForm.insertBefore(
                        errorForm,
                        document.getElementById("form-id")
                    );
                } else {
                    window.location.reload();
                }
            }
        })
    }
})()