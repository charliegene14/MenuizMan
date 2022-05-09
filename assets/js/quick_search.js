(function() {
    var form    = document.getElementById("quick-search");

    /**
     * send quick search form with post method
     */
    if(form) {
        
        var input   = form.querySelector("input");
        var ul      = form.querySelector("ul");
        var btn     = form.querySelector("button");
        input.onkeyup = function(e) {

            let value = input.value;

            $.post({

                url: "./?p=search",
                data: {
                    searched: "quick",
                    id: value,
                },
                success: function(ids) {
                    
                    refreshAutocomplete(JSON.parse(ids));
                }
            });
        }

        /**
         * Display autocomplete div on quick search
         * @param {int} ids 
         */
        function refreshAutocomplete(ids) {

            ul.innerHTML = "";
            
            if (ids.length > 0) {
                
                for (id in ids) {

                    let li = document.createElement("li");
                    li.innerHTML = "<a href='./?p=ticket&action=show&id=" + ids[id] + "'>" + ids[id] + "</a>";
                    ul.appendChild(li);
                }

                ul.classList.add("active");

            } else {
                ul.classList.remove("active");
            }

        }
    }
})()