

    <div class="card" id="ticket-<?= $ticketNumber ?>">
  
      <h3 class="card-header">
        <span class="ticket-title">Ticket n°<?= $ticketNumber ?></span>

        <?php if ($ticketNumber > 1): ?>
          <i class="fa-solid fa-square-minus delete-ticket"></i>
        <?php endif; ?>
      </h3>
  
      <?php if ($type->getId() !== "NPAI" && $type->getId() !== "NP") include "views/templates/create_tickets_forms/product_choice.php"; ?>
      <?php if ($type->getId() === "NPAI" || $type->getId() === "NP") include "views/templates/create_tickets_forms/new_address.php"; ?>

  
      <div class="card-body">
        <p class="card-title"><label for="commentary">Commentaire</label></p>
        <textarea placeholder="(facultatif)" class="form-control commentary" name="tickets][<?= $ticketNumber ?>][commentary]" cols="30" rows="3"></textarea>
        <div class="messerror" style="display:none">Maximum 50 caractères</div>
      </div>
  
    </div>

