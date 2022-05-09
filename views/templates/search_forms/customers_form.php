<form id="form-search" class="form-search" method="post">
  <fieldset>
    <legend>Recherche de client</legend>
    <div class="form-group">
      <input type="text" class="form-control inputTypeName" id="form-fncustomer-search" placeholder="Prénom Client" name="custFirstName">
      <div class="messerror" style="display:none">Caractères interdits</div>
    </div>
    <div class="form-group">
      <input type="text" class="form-control inputTypeName" id="form-lncustomer-search" placeholder="Nom Client" name="custLastName">
      <div class="messerror" style="display:none">Caractères interdits</div>
    </div>
    <div class="form-group">
      <input type="text" class="form-control inputTypeTEL" id="form-phonenumber-search" name="numTel" placeholder="Numéro de téléphone">
      <div class="messerror" style="display:none">Au moins 10 caractères</div>
    </div>
    <div class="form-group">
      <input type="text" class="form-control inputTypeInt" id="form-num-purchase-search" name="purchaseID" placeholder="Numéro de commande">
      <div class="messerror" style="display:none">Numéro de commande incorrect</div>
    </div>
    <div class="form-group">
      <fieldset id="address-subsearch">
        <legend>Adresse</legend>
        <input type="text" class="form-control inputTypeInt" id="form-streetNumber-search" name="streetNumber" placeholder="Numéro de la rue">
        <div class="messerror" style="display:none"> Numéro de rue incorrect</div>
        <input type="text" class="form-control inputTypeName" id="form-streetName-search" name="streetName" placeholder="Nom de la rue">
        <div class="messerror" style="display:none"> Caractères interdits</div>
        <input type="text" class="form-control inputTypeCP" id="form-cp-search" name="postCode" placeholder="Code postal">
        <div class="messerror" style="display:none"> Code postal incorrect</div>
        <input type="text" class="form-control inputTypeName" id="form-streetName-search" name="cityName" placeholder="Ville">
        <div class="messerror" style="display:none"> Caractères interdits</div>
      </fieldset>
    </div>
    
    <input type="hidden" name="searched" value="customer">
    <input type="button" class="btn btn-primary form-search-submit" value ="Rechercher"> 
    <div class="messerror" style="display:none" id="submitError"> Recherche impossible : merci de vérifier les champs</div>
    <input type="button" class="btn btn-primary" value="Recherche Précédente" id="lastSearch">
  </fieldset>
</form>

