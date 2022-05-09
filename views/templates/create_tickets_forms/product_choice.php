<div class="card-body">
      <p class="card-title">Article concerné</p>

      <table class="table">
        <thead>
            <tr>
                <th>Article</th>
                <th>Qté</th>
            </tr>
        </thead>
        <tbody>

        <?php

          function recursive($compo, $array) {

            array_walk_recursive($compo, function($value, $key, $array) {

              echo "<tr>";
              echo "<td class='ticket-choose-article'>";

              ?>
                <input
                  type="radio"
                  name="tickets][<?= $array[1] ?>][article][id]"
                  value="<?= $value->getArticle()->getId(); ?>"
                  id="article-<?= $array[1] ?>-<?= $array[2] ?>-<?= $value->getArticle()->getId(); ?>"
                  class="article-<?= $array[1] ?>-<?= $array[2] ?>-<?= $value->getArticle()->getId(); ?>"
                  required
                  >
              <?php

              for ($j = 0; $j < $array[0]; $j++) {
                echo "&nbsp;-&nbsp;";
              }

              ?>
                <label class="form-label" for="article-<?= $array[1] ?>-<?= $array[2] ?>-<?= $value->getArticle()->getId(); ?>"><?= $value->getArticle()->getName(); ?></label>
              <?php
              echo "</td>";

            
              echo "<td class='ticket-choose-qty'>";

              ?>
                <input
                  class="form-control input-qty-ticket-<?= $array[1] ?> article-<?= $array[1] ?>-<?= $array[2] ?>-<?= $value->getArticle()->getId(); ?>"
                  name="tickets][<?= $array[1] ?>][article][quantity]"
                  type="number"
                  min="1"
                  max="<?= $value->getQuantity(); ?>"
                  disabled = "disabled"
                >
                &nbsp;/&nbsp;<?= $value->getQuantity(); ?>
              <?php

              echo "</td>";
                
              echo "</tr>";

              if (!empty($value->getArticle()->getComposition())) {
                $array[0]++;
                $array[2] = $value->getArticle()->getId();
                recursive($value->getArticle()->getComposition(), $array);
              }

            }, $array);


          } ?>

          <?php foreach ($purchase->getArticles() as $article): ?>
            <tr>
              <td class="ticket-choose-article">

                <input
                  type="radio"
                  name="tickets][<?= $ticketNumber ?>][article][id]"
                  value="<?= $article->getArticle()->getId(); ?>"
                  id="article-<?= $ticketNumber ?>-<?= $article->getArticle()->getId(); ?>"
                  class="article-<?= $ticketNumber ?>-<?= $article->getArticle()->getId(); ?>"
                  required
                >

                <label class="form-label" for="article-<?= $ticketNumber ?>-<?= $article->getArticle()->getId(); ?>"><?= $article->getArticle()->getName(); ?></label>

              </td>

              <td class="ticket-choose-qty">
                <input
                  class="form-control input-qty-ticket-<?= $ticketNumber ?> article-<?= $ticketNumber ?>-<?= $article->getArticle()->getId(); ?>"
                  name="tickets][<?= $ticketNumber ?>][article][quantity]"
                  type="number" 
                  min="1"
                  max="<?= $article->getQuantity(); ?>"
                  disabled = "disabled"
                >
                &nbsp;/&nbsp;<?= $article->getQuantity(); ?>
              </td>

            </tr>

            <?php if (!empty($article->getArticle()->getComposition())): ?>

               <?php
                $idParent = $article->getArticle()->getId();
                recursive($article->getArticle()->getComposition(), [1, $ticketNumber, $idParent]);
                
              ?>

              <?php endif; ?>

          <?php endforeach;?>

        </tbody>
      </table>

</div>