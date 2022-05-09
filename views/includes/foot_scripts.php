<script src="https://bootswatch.com/_vendor/bootstrap/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<script src="./assets/js/global.js"></script>
<script src="./assets/js/quick_search.js"></script>

<?php if (isset($_GET['p']) && $_GET['p'] === "stats"): ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"
    integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>
<script src="./assets/js/stats.js"></script>

<?php endif; ?>