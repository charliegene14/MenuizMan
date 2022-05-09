<div class="card-body">
      <p class="card-title">Adresse actuelle</p>
      <p><?= $purchase->getCustomer()->getFirstName() . " " .$purchase->getCustomer()->getLastName()  ?><br />
      <?= $purchase->getCustomer()->getAddress(); ?></p>
</div>

<div class="card-body">
      <p class="card-title">Nouvelle adresse (facultatif)</p>
      
      <label for="adress-number">Numéro</label>
      <input class="form-control" type="text" name="tickets][<?= $ticketNumber ?>][address][number]" id="adress-number">

      <label for="adress-street">Voie/Rue</label>
      <input class="form-control" type="text" name="tickets][<?= $ticketNumber ?>][address][street]" id="adress-street">

      <label for="adress-postal">Code postal</label>
      <input class="form-control" type="text" name="tickets][<?= $ticketNumber ?>][address][postal]" id="adress-postal">

      <label for="adress-cog">COG</label>
      <input class="form-control" type="text" name="tickets][<?= $ticketNumber ?>][address][cog]" id="adress-cog">

      <label for="adress-city">Ville</label>
      <input class="form-control" type="text" name="tickets][<?= $ticketNumber ?>][address][city]" id="adress-city">

</div>