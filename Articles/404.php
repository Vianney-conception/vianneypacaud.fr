<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur 404</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/articles.css">
    <script src="/JS/chargement.js"></script>
    <link rel="icon" href="https://vianneypacaud.fr/img/LogoCouleur.png" type="image/x-icon">
</head>
<?php
include '../chargement.php';
?>
<div id="GlobalSite" style="display:none;">
    <?php
    include '../header.php';
    ?>
    <article>
        <h1 class="Introuvable">404</h1>
        <p><strong>Oups !</strong> Il semble que cette page n'existe pas.</p>

        <div id="ZonedeRecherche">
            <div class="ZonedeRechercheContenant"><input placeholder="Rechercher sur ce site..." type="text">
                <div class="ZonedeProposition"></div>
            </div>
        </div>
        <p><a href="/">Retourner à l'acceuil</a></p>

    </article>

    <?php
    include '../footer.php';
    ?>
</div>
</body>

<script src="/JS/search.js"></script>
<script src="/JS/fond.js"></script>
<script src="/JS/modal.js"></script>
<script src="/JS/articles.js"></script>

</html>