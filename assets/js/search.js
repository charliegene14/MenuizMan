var btnSubmit;
var btnChangeFilter;
var navBtn = document.getElementsByClassName("nav-form");
var formList = document.getElementsByClassName("form-control");
var divAccordeon = document.getElementsByClassName("search-subtittle");
var divAccArrow = document.getElementsByClassName("accordeon-arrow");
var searchFormContainer = document.getElementById("search-form");
var inputInt = document.getElementsByClassName("inputTypeInt");
var inputPrice = document.getElementsByClassName("inputTypePrice");
var lastSearch = document.getElementById("lastSearch");
var bSearch = true;


/**
 * Subscribe tab forms to display the matching form
 */
for (let btn of navBtn){
    btn.addEventListener("click",function(){
        for (let btn of navBtn){
            btn.setAttribute("class","nav-form");
        }
        btn.setAttribute("class","nav-form selected-search");
        showForm(btn);
    });
}

/**
 * Subsribe commit button while form is appearing
 */
function submitListenClick(){
    
    btnSubmit = document.getElementsByClassName("form-search-submit");

    for (let submit of btnSubmit) {
        submit.addEventListener("click",function(){
            if(bSearch) {
                document.getElementById("submitError").style.display ="none";
                var inputList = document.getElementsByClassName("form-control");
                for (let input of inputList){
                    sessionStorage.setItem(input.getAttribute("name"),input.value);
                }
                document.getElementById("form-search").submit();
            } else {
                document.getElementById("submitError").style.display ="block";
            }
        });
    }
}

/**
 * Subscribe each main accordion div to show details onclick
 */
for (let accordeon of divAccordeon){
    accordeon.addEventListener("click",function(){displayinfos(accordeon)});
}

/**
 * Display details
 * @param {HTMLElement} elemtAccordeon 
 */
function displayinfos(elemtAccordeon){
   let toggled = elemtAccordeon.nextElementSibling.classList.toggle("search-default-show");
   let divArrow = elemtAccordeon.getElementsByTagName("div")[1];

   if(toggled){
       elemtAccordeon.nextElementSibling.setAttribute("class","search-default-show");
       divArrow.innerHTML = '<i class="fa-solid fa-arrow-up"></i>';
   } else {
       elemtAccordeon.nextElementSibling.setAttribute("class","search-default-hidden");
       divArrow.innerHTML = '<i class="fa-solid fa-arrow-down"></i>';
   }
}

/**
 * Display the right form after tab click
 * 
 * @param {HTMLElement} btn 
 */
function showForm(btn) {

    var phpfile = "./views/templates/search_forms/";

    phpfile += btn.getAttribute("name") + ".php";
    searchFormContainer.innerHTML ="";
    if(document.getElementById("search-results")){
        var divResult = document.getElementById("search-results");
        document.getElementById("main-div-search").removeChild(divResult);
    }

    $.get({
        method:"get",
        url: phpfile,
        success: function(data){
            searchFormContainer.innerHTML = data;
            submitListenClick();
            lastSearchBtn();
            fillInputList();
        }
    })
}

/**
 * Geting the right form inputs lists after appearing
 */
function fillInputList() {
    inputInt = document.getElementsByClassName("inputTypeInt");
    subscribeInputInt(inputInt);

    inputName = document.getElementsByClassName("inputTypeName");
    subscribeInputName(inputName);

    inputDate = document.getElementsByClassName("inputDate");
    subscribeInputDate(inputDate);

    inputCP = document.getElementsByClassName("inputTypeCP");
    subscribeInputCP(inputCP);

    inputTEL = document.getElementsByClassName("inputTypeTEL");
    subscribeInputTEL(inputTEL);

    inputPrice = document.getElementsByClassName("inputTypePrice");
    subscribeInputPrice(inputPrice);
}

/**
 * Controlling input field of price type 
 * 
 * @param {HTLMElement} inputPrice 
 */
function subscribeInputPrice(inputPrice) {

    for (let input of inputPrice) {

        input.addEventListener("keyup",function(){
            var testedInput = input.value;
            var divError = input.nextElementSibling;
            
            if (!testedInput) {
                divError.style.display = "none";
                bSearch = true;
                return;
            }

            testedInput = testedInput.replace(",", ".");

            if(isNaN(testedInput) || parseFloat(testedInput * 100) != parseInt(testedInput *100) || testedInput<0) {
                divError.style.display = "block";
                bSearch = false;
                return;
            } 
            divError.style.display = "none";
            bSearch = true;       
        });
    }
}

/**
 * Controlling input field of int type 
 * 
 * @param {HTLMElement} inputPrice 
 */
function subscribeInputInt(inputInt){
    for (let input of inputInt) {
        input.addEventListener("keyup",function(){
            var testedInput = input.value;
            var divError = input.nextElementSibling;
            
            if (!testedInput) {
                divError.style.display = "none";
                bSearch = true;
                return;
            }

            if(isNaN(testedInput) || parseFloat(testedInput)!=parseInt(testedInput) || testedInput<0 || testedInput.includes(".")) {
                divError.style.display = "block";
                bSearch = false;
                return;
            } 
            divError.style.display = "none";
            bSearch = true;       
        });
    }
}

/**
 * Controlling input field of Name type 
 * 
 * @param {HTLMElement} inputPrice 
 */
function subscribeInputName(inputName) {
    var regex = /^[a-zA-Z\u00C0-\u00FF\s\'\-]*$/;
    for (let input of inputName) {
        input.addEventListener("keyup",function(){
            var testedInput = input.value;
            var divError = input.nextElementSibling;
            
            if (!testedInput) {
                divError.style.display = "none";
                bSearch = true;
                return;
            }

            if(!regex.test(testedInput)) {
                divError.style.display = "block";
                bSearch = false;
                return;
            } 
            divError.style.display = "none";
            bSearch = true;        
        });
    }
}
    
/**
 * Controlling input field of date type 
 * 
 * @param {HTLMElement} inputPrice 
 */
function subscribeInputDate(inputDate) {
    var regex = /(((0[1-9]|[12][0-9]|3[01])([/])(0[13578]|10|12)([/])(\d{4}))|(([0][1-9]|[12][0-9]|30)([/])(0[469]|11)([/])(\d{4}))|((0[1-9]|1[0-9]|2[0-8])([/])(02)([/])(\d{4}))|((29)(\/)(02)([/])([02468][048]00))|((29)([/])(02)([/])([13579][26]00))|((29)([/])(02)([/])([0-9][0-9][0][48]))|((29)([/])(02)([/])([0-9][0-9][2468][048]))|((29)([/])(02)([/])([0-9][0-9][13579][26])))/;
    
    for (let input of inputDate) {
        input.addEventListener("keyup",function(){
            var testedInput = input.value;
            var divError = input.nextElementSibling;
            
            if (!testedInput) {
                divError.style.display = "none";
                bSearch = true;
                return;
            }

            if(!regex.test(testedInput)) {
                divError.style.display = "block";
                bSearch = false;
                return;
            } 
            divError.style.display = "none";
            bSearch = true;        
        });
    }
} 

/**
 * Controlling input field of postCode type 
 * 
 * @param {HTLMElement} inputPrice 
 */
function subscribeInputCP(inputCP) {
    var regex = /^(?:(?:(?:0[1-9]|[1-8]\d|9[0-5])(?:\d{3})?)|97[1-8]|98[4-9]|2[abAB])$/;
   
    for (let input of inputCP) {
        input.addEventListener("keyup",function(){
            var testedInput = input.value;
            var divError = input.nextElementSibling;

            if (!testedInput) {
                divError.style.display = "none";
                bSearch = true;
                return;
            }

            if(!regex.test(testedInput)) {
                divError.style.display = "block";
                bSearch = false;
                return;
            } 
            divError.style.display = "none";
            bSearch = true;        
        });
    }
}

/**
 * Controlling input field of telephone number type 
 * 
 * @param {HTLMElement} inputPrice 
 */
function subscribeInputTEL(inputTEL) {
    var regex = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/;
   
    for (let input of inputTEL) {
        input.addEventListener("keyup",function(){
            var testedInput = input.value;
            var divError = input.nextElementSibling;

            if (!testedInput) {
                divError.style.display = "none";
                bSearch = true;
                return;
            }

            if(!regex.test(testedInput)) {
                divError.style.display = "block";
                bSearch = false;
                return;
            } 
            divError.style.display = "none";
            bSearch = true;        
        });
    }
}

/**
 * Finding last search from sessionStorage and fill the matching fields in form
 */
function lastSearchBtn() {
    lastSearch = document.getElementById("lastSearch");
    lastSearch.addEventListener("click",function(){
        var inputList = document.getElementsByClassName("form-control");
        for (let input of inputList) {
            input.value = sessionStorage.getItem(input.name);
        }
    })
}