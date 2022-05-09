(function(){

    var formPurchase        = document.getElementById("purchase");
    var purchaseSelector    = document.getElementById("purchase-autocomplete");
    var purchaseSelectorUl  = document.querySelector("#purchase-autocomplete ul");
    var inputPurchase       = document.getElementById("input-purchase");
    var pErrorPurchase      = document.getElementById("error-purchase");
    var addTicketBtn        = document.getElementById("add-ticket");
    var ticketList          = document.getElementById("ticket-list");
    var inputType           = document.getElementById("input-type");
    var formTicket          = document.getElementById("all-tickets");
    var comments            = document.getElementsByClassName("commentary");
    var bComment            = true;
    var deleteTicketBtns;
    var tickets;
    var inputQty = {};

    var ticketNumber = 1;

    // Subscribe "commit" button from create ticket page
    if (formTicket) {

        subscribeCommentDiv();
        subscribeRadioBtn();
        
        formTicket.onsubmit = function(e) {
           
            e.preventDefault();
            if(!bComment) { return};
            let datas = Object.fromEntries(new FormData(e.target).entries());

            $.post({
                url: "./?p=ticket&action=create&purchase_id=" + datas.purchaseID + "&ticket_type=" + datas.ticketType,
                data: {
                    action: "ajax_submit_ticket",
                    datas: datas
                },
                beforeSend: function() {
                    document.getElementById("loader").classList.add("active");
                    document.querySelector("#loader img").classList.add("active");

                },
                success: function(tickets) {
    
                    tickets = JSON.parse(tickets);

                    html = "<div style='color: var(--white); font-weight: bold; font-size: 1.2rem;'>";

                    for (let ticket in tickets) {

                        if (tickets[ticket] !== null) {

                            html += "<i class='fa-solid fa-circle-check'></i>&nbsp";
                            html += "Ticket n°" + ticket;
                            html += " (réf. " + tickets[ticket] + ") ";
                            html += "créé avec succès&nbsp; <a href='./?p=ticket&action=show&id=" + tickets[ticket] + "'>Voir sa page</a>"
                            html += "<br />";
                        }

                        else {

                            html += "<i class='fas fas-circle-xmark'></i>Un problème est survenu sur le ticket n°";
                            html += tickets[ticket];
                            html += "<br />";
                        }
                    }

                    html += "<a href='/'>Retourner à l'accueil</a></div>";

                    document.querySelector("#loader #message").innerHTML = html;
                    document.querySelector("#loader img").classList.remove("active");
                    document.querySelector("#loader #message").classList.add("active");

                },
                error: function(data) {
                    console.log(data.responseText);
                }
            })
        }
    }

    if (addTicketBtn) {

        addTicketBtn.onclick = function(e) {
            
            let purchaseID = inputPurchase.value;
            let typeID = inputType.value;
    
            ticketNumber++;
            addTicketForm(purchaseID, typeID);   
        }
    }

    /**
     * Subscribe radio buttons from forms to able/disable matching quantity input
     *
     * @return void
     */
    function subscribeRadioBtn() {

        inputQty = {
            "1": document.querySelectorAll(".input-qty-ticket-1"),
        };

        let radioBtns = document.querySelectorAll("input[type=radio]");

        for (let i in radioBtns) {
            let btn = radioBtns[i];

            btn.onchange = function(e) {
                let qty = document.querySelector("input[type=number]."+btn.getAttribute("class"));
                let qtyclass =qty.getAttribute("class").split(" ")[1];
                let qtyList = document.getElementsByClassName(qtyclass);
                for (let singleqty of qtyList){
                    singleqty.disabled=true;
                    
                }
                qty.disabled=false;
        
            }

        }

    }

    /**
     * Subscribe "delete" button from a single form after deleting an entire form
     *
     * @return void
     */
    function refreshDeleteButtons() {

        deleteTicketBtns = document.querySelectorAll(".delete-ticket");
        
        for (let deleteBtn of deleteTicketBtns) {
            deleteBtn.onclick = function(e) {
                this.parentNode.parentNode.remove();
                ticketNumber--;

                refreshTicketsNumber();
            }
        }
    }

    /**
     * Subscribe "delete" button from a single form after deleting an entire form
     *
     * @return void
     */
    function refreshTicketsNumber() {

        ticketsTitle = ticketList.querySelectorAll(".card-header .ticket-title");
        let i = 1;

        for (let title of ticketsTitle) {

            title.parentNode.parentNode.id = "ticket-" + i;

            title.innerText = "Ticket n°" + i;
            i++;
        }
    }

    /**
     * Add a ticket form after selected valid purchase ID
     * Or cliked on "Add ticket" button
     */
    function addTicketForm(purchaseID, typeID) {

        $.post({
            url: "./?p=ticket&action=create&purchase_id=" + purchaseID + "&ticket_type=" + typeID,
            data: {
                action: "ajax_add_ticket_form",
                ticketNumber: ticketNumber,
            },
            success: function(page) {
    
                page = new DOMParser().parseFromString(page, "text/html").body.firstChild;
                ticketList.appendChild(page);
                subscribeCommentDiv();
                refreshDeleteButtons();

                inputQty[ticketNumber] = document.querySelectorAll(".input-qty-ticket-" + ticketNumber);

                subscribeRadioBtn()
            }
        })
    }

    /**
     * Subscribe "Commentary" div from a single form 
     *
     * @return void
     */
    function subscribeCommentDiv() {
        comments = document.getElementsByClassName("commentary");

        for (let commentary of comments) {
            commentary.onkeydown = function() {
                
                if(commentary.value.length > 50){
                    commentary.nextElementSibling.style.display = "block";
                    bComment = false;
                } else {
                    commentary.nextElementSibling.style.display = "none";
                    bComment = true;
                }
            }
        }
    }

    function ajaxPurchaseValidation(id) {

        $.post({
            url: "./?p=ticket&action=create&purchase_id=" + id,
            data: {
                action: "ajax_purchase_validation",
            },
            success: function(isValid) {

                purchaseValidation(id, JSON.parse(isValid));
            }
        })
    }

    function purchaseAutoComplete(aID) {

        purchaseSelectorUl.innerHTML = "";

        for (id of aID) {
            let li = document.createElement("li");
            li.innerText = id;
            purchaseSelectorUl.appendChild(li);
        }


        if (aID.length != 0) {

            purchaseSelector.classList.add('active');

        } else if (aID.length == 0) {

             purchaseSelector.classList.remove('active');
        }

        /**
         * Event on each ID in select
         */
        var purchaseSelectorLi  = document.querySelectorAll("#purchase-autocomplete li");

        for (let purchase of purchaseSelectorLi) {

            let id = purchase.innerText;
            
            purchase.onclick = function(e) {

                inputPurchase.value = id;
                ajaxPurchaseValidation(id);

                if (purchaseSelector.classList.contains("active")) {
                    purchaseSelector.classList.remove("active");
                }
            }
        }
    }

    function ajaxGetPurchases(value) {

        $.post({
            url: "./?p=ticket&action=create",
            data: {
                action: "ajax_get_purchases",
                value: value,
            },
            success: function(returns) {
                purchaseAutoComplete(JSON.parse(returns));
            },
            error: function(data) {
                console.log(data);
            }
        })
    }

    /**
     * 
     * @param {boolean} isValid
     * Add ticket form if true
     * Write error if false
     */
    function purchaseValidation(id, isValid) {

        if (isValid) {
            window.location.href = "./?p=ticket&action=create&purchase_id=" + id;
        } else {
            pErrorPurchase.classList.add("active");
        }
    }

    /**
     * Async purchase ID validation to PHP script
     * Whether input is submit
     */
    formPurchase.onsubmit = function(e) {

        e.preventDefault();
        let id = inputPurchase.value;
        ajaxPurchaseValidation(id);

        if (purchaseSelector.classList.contains("active")) {
            purchaseSelector.classList.remove("active");
        }
       
    };

    inputPurchase.onkeydown = function(e) {
        if (pErrorPurchase.classList.contains("active")) {
            pErrorPurchase.classList.remove("active");
        }
    }

    inputPurchase.onkeyup = function(e) {

        let value = this.value;

        if (e.keyCode != 13 )
            ajaxGetPurchases(value);
    }

})()
