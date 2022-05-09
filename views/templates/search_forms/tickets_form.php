<form id="form-search" class="form-search" action="?p=search" method="post">
  <fieldset>
    <legend>Recherche de tickets</legend>
    <div class="form-group">
      <input type="text" class="form-control inputTypeInt" id="form-num-ticket-search" placeholder="Numéro de ticket" name="ticketID">
      <div class="messerror" style="display:none"> Le numéro de ticket doit être un nombre entier</div>
    </div>
    
    <div class="form-group">
      <input type="text" class="form-control inputTypeInt" id="form-num-purchase-search" placeholder="Numéro de commande" name="purchaseID">
      <div class="messerror" style="display:none"> Le numéro de commande doit être un nombre entier</div>
    </div>
    <div class="form-group">
      <input type="text" class="form-control inputTypeName" id="form-fncustomer-search" placeholder="Prénom Client" name="custFirstName">
      <div class="messerror" style="display:none"> Caractères interdits</div>
    </div>
    <div class="form-group">
      <input type="text" class="form-control inputTypeName" id="form-lncustomer-search" placeholder="Nom Client" name="custLastName">
      <div class="messerror" style="display:none"> Caractères interdits</div>
    </div>
    <div class="form-group">
        <label for="form-creationdate-search">Date de création</label> <br>
      <input type="date" class="form-control inputTypeDate" id="form-creationdate-search" name="startingTime" >
      <div class="messerror" style="display:none"> Format date incorrect</div>
    </div>
  
    <input type="hidden" name="searched" value="ticket">
    <input type="button" class="btn btn-primary form-search-submit" value ="Rechercher"> 
    <div class="messerror" style="display:none" id="submitError"> Recherche impossible : merci de vérifier les champs</div>
    <input type="button" class="btn btn-primary" value="Recherche Précédente" id="lastSearch">
    
</form>