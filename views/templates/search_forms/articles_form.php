<form id="form-search" class="form-search" method="post">
  <fieldset>
    <legend>Recherche d'article</legend>
    
    <div class="form-group">
      <input type="text" name="articleID" class="form-control inputTypeInt" id="form-num-purchase-search" placeholder="Numéro d'article">
      <div class="messerror" style="display:none">Caractères interdits</div>
    </div>

    <div class="form-group">
      <input type="text" name="articleName" class="form-control inputTypeName" id="form-articlename-search" placeholder="Nom article">
      <div class="messerror" style="display:none">Caractères interdits</div>
    </div>

    <div class="form-group">
      <input type="text" name="articlePriceMin" class="form-control inputTypePrice" id="form-minprice-search" placeholder="Prix minimum">
      <div class="messerror" style="display:none">Caractères interdits</div>
    </div>

    <div class="form-group">
      <input type="text" name="articlePriceMax" class="form-control inputTypePrice" id="form-maxprice-search" placeholder="Prix maximum">
      <div class="messerror" style="display:none">Caractères interdits</div>
    </div>

    <div class="form-group" id="div-radio-stock">
      <span id="span-in-stock">Présent en stock</span>

      <input type="checkbox" id="form-instorage-search" name="form-inphys-search" checked>
      <label for="form-inphys-search">Physique</label>

      <input type="checkbox" id="form-instorage-search" name="form-insav-search" checked>
      <label for="form-insav-search">SAV</label>

      <input type="checkbox" id="form-instorage-search" name="form-inrebus-search" checked>
      <label for="form-inrebus-search">Rebus</label>

    </div>

    <input type="hidden" name="searched" value="article">
    <input type="button" class="btn btn-primary form-search-submit" value ="Rechercher">

    <div class="messerror" style="display:none" id="submitError">Recherche impossible : merci de vérifier les champs</div>
    <input type="button" class="btn btn-primary" value="Recherche Précédente" id="lastSearch">

  </fieldset>

</form>