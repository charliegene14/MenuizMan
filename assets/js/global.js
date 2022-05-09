(function() {

    var arrowBack   = document.querySelector(".main-title i.fa-circle-arrow-left");

    var loader      = document.getElementById("loader");
    var loaderIMG   = document.querySelector("#loader img");
    var loaderMSG   = document.querySelector("#loader #message");

    /**
     * Previous page
     */
    if(arrowBack) {
        arrowBack.onclick = function(e) {
            history.back()
        }
    }

    /**
     * Loader on loading page
     */
    window.onload = function(e) {

        window.setTimeout(function() {
            loader.classList.remove("active");
            loaderIMG.classList.remove("active");
        }, 4)
    }

    /**
     * Loader on unloading page
     */
    window.onbeforeunload = function () {
        loader.classList.add("active");
        loaderIMG.classList.add("active");
    }


})()