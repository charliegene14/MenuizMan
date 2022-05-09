
<?php if ($user->getRole()->getId() !== "ADM"): ?>

<header>
    
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="./"><img src="./assets/img/logo_sm.png" /></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor03">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="./">
          <i class="fa-solid fa-house"></i>
            Accueil
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <i class="fa-solid fa-clipboard-list"></i>
            Voir les tickets
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="./?p=tickets&action=to_diag">Nécessitant diagnostique</a>
            <a class="dropdown-item" href="./?p=tickets&action=to_ship">Nécessitant expédition</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="./?p=tickets&action=closed">Finalisés</a>
          </div>
        </li>

        <?php if ($user->getRole()->getId() !== "MNG"): ?>

        <li class="nav-item">
          <a class="nav-link" href="./?p=ticket&action=create">
          <i class="fa-solid fa-file-circle-plus"></i>
            Nouveau ticket
          </a>
        </li>

        <?php endif; ?>

        <?php if ($user->getRole()->getId() === "MNG"): ?>

        <li class="nav-item">
          <a class="nav-link" href="./?p=stats">
          <i class="fa-solid fa-chart-simple"></i>
            Statistiques
          </a>
        </li>

        <?php endif; ?>
        
        <li class="nav-item">
          <a class="nav-link" href="./?p=profil">
          <i class="fa-solid fa-id-card-clip"></i>
            Mon profil
          </a>
        </li>
      </ul>

      <a id="advanced-search-link" href="./?p=search">
      <i class="fa-solid fa-magnifying-glass-arrow-right"></i>
        Recherche avancée
      </a>

      <form id="quick-search" class="d-flex" method="post" action="./?p=search">
        <div>
          <input class="form-control me-sm-2" type="text" name="ticketID" placeholder="Recherche ID ticket">
          <ul>
          </ul>
        </div>

        <input type="hidden" name="searched" value="ticket">

        <button class="btn btn-primary my-2 my-sm-0" type="submit">Rechercher</button>
      </form>

    </div>
  </div>
</nav>


</header>
<?php else: ?>
  <?php include "views/admin/header.php" ?>
<?php endif; ?>