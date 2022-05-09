<form id="form-search" class="form-search" method="post">
  <fieldset>

    <legend>Recherche de commande</legend>

    <div class="form-group">
      <input type="text" name="purchaseID" class="form-control inputTypeInt" id="form-num-purchase-search" placeholder="Numéro de commande">
      <div class="messerror" style="display:none">Caractères interdits</div>
    </div>

    <div class="form-group">
      <input type="text" name="custFirstName" class="form-control inputTypeName" id="form-lastname-customer-search" placeholder="Prénom Client">
      <div class="messerror" style="display:none">Caractères interdits</div>
    </div>

    <div class="form-group">
      <input type="text" name="custLastName" class="form-control inputTypeName" id="form-lastname-customer-search" placeholder="Nom Client">
      <div class="messerror" style="display:none">Caractères interdits</div>
    </div>

    <div class="form-group">
      <input type="text" name="purchaseInvoice" class="form-control inputTypeInt" id="form-invoiche-search" placeholder="Numéro de facture">
      <div class="messerror" style="display:none">Caractères interdits</div>
    </div>

    <div class="form-group">
        <label for="form-purchasedate-search">Date de commande</label> <br>
        <input type="date" name="purchaseDate" class="form-control" id="form-purchasedate-search">
    </div>

    
    <input type="hidden" name="searched" value="purchase">
    <input type="button" class="btn btn-primary form-search-submit" value ="Rechercher">

    <div class="messerror" style="display:none" id="submitError">Recherche impossible : merci de vérifier les champs</div>
    <input type="button" class="btn btn-primary" value="Recherche Précédente" id="lastSearch">

  </fieldset>
</form>