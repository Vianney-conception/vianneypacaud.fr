<?php include 'listeArticles.php'; ?>
<?php
$request_uri = $_SERVER['REQUEST_URI'];
$path = trim(parse_url($request_uri, PHP_URL_PATH), '/');
$segments = explode('/', $path);
$article_cible = '';
foreach ($segments as $index => $segment) {
    if (strtolower($segment) === 'gervo' && isset($segments[$index + 1])) {
        $article_cible = $segments[$index + 1];
        break;
    }
}
if (empty($article_cible)) {
    $article_cible = 'accueil';
}
$fichier_a_inclure = $article_cible . '_Article.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gervo - <?php if (isset($config[$article_cible])) {
        echo $config[$article_cible];
    } else {
        echo "Article introuvable";
    } ?>
    </title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/articles.css">
    <?php if ($article_cible != "GervoOutils"){
        echo '<link rel="stylesheet" href="/styles/headerArticle.css">';
    } ?>
    <script src="/JS/chargement.js"></script>
    <link rel="icon" href="https://vianneypacaud.fr/img/LogoGervo.png" type="image/x-icon">
    <?php include '../Partage.php' ?>
</head>
<?php
include '../chargement.php';
?>
<div id="GlobalSite" style="display:none;">
    <?php
    include '../header.php';
    ?>
    <article>
        <?php
        if (file_exists($fichier_a_inclure)) {
            include($fichier_a_inclure);
        } else {
            include '../Articles/Article404.php';
        }
        ?>
    </article>

    <?php
    include '../footer.php';
    ?>
</div>
</body>
<script src="/JS/fond.js"></script>
<script src="/JS/modal.js"></script>
<script src="/JS/articles.js"></script>
</html>