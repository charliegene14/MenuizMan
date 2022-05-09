var divCommand = document.getElementsByClassName("detail-subtittle");

/**
 * Subsribe all command to show onclick
 */
for (let command of divCommand) {

    command.addEventListener('click',function(){displayCommand(command)});
}

/**
 * Display details from a purchase
 * @param elemtAccordeon 
 */
function displayCommand(elemtAccordeon){
    let toggled = elemtAccordeon.nextElementSibling.classList.toggle("detail-purchase-show");

    let divArrow = elemtAccordeon.getElementsByTagName("div")[1];

    if(toggled){

        elemtAccordeon.nextElementSibling.setAttribute("class","detail-purchase-show");
        divArrow.innerHTML = '<i class="fa-solid fa-arrow-up"></i>';
    } else {

        elemtAccordeon.nextElementSibling.setAttribute("class","detail-purchase-hidden");
        divArrow.innerHTML = '<i class="fa-solid fa-arrow-down"></i>';
    }
}