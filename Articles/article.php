<?php include 'listeArticles.php'; ?>
<?php
$request_uri = $_SERVER['REQUEST_URI'];
$path = trim(parse_url($request_uri, PHP_URL_PATH), '/');
$segments = explode('/', $path);
$article_cible = '';
foreach ($segments as $index => $segment) {
    if (strtolower($segment) === 'articles' && isset($segments[$index + 1])) {
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
    <title>Vianney Pacaud - <?php if (isset($config[$article_cible])) {
        echo $config[$article_cible];
    } else {
        echo "Article introuvable";
    } ?>
    </title>
    <link rel="stylesheet" href="/styles/styles.css">
    <link rel="stylesheet" href="/styles/articles.css">
    <script src="/JS/chargement.js"></script>
    <link rel="icon" href="https://vianneypacaud.fr/img/LogoCouleur.png" type="image/x-icon">
    <?php include '../Partage.php' ?>
</head>
<?php
include '../chargement.php';
?>
<div id="GlobalSite" style="display:none;">
    <?php
    include '../header.php';
    ?>
    <div id="SommaireArticle" class="Sommaire">
        <div class="enteteSommaire">
            <h2>Sommaire :</h2>
            <button onclick="deploieSommaire()" class="btn-sommaire">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-summary preview-icon">
                    <g class="cross-group">
                        <path class="line-top" d="M15 4H7" />
                        <path class="line-mid" d="M7 9h12" />
                    </g>
                    <path class="line-bot" d="M3 4v13a2 2 0 0 0 2 2h16" />
                    <path class="hidden-line-1" d="m18 16 3 3-3 3" />
                    <path class="hidden-line-2" d="M7 14h7" />
                </svg>
            </button>
        </div>
        <div id="contenuSommaire">
            <nav>
                <ul>
                </ul>
            </nav>
        </div>
    </div>
    <article>
        <?php
        if (file_exists($fichier_a_inclure)) {
            include($fichier_a_inclure);
        } else {
            include 'Article404.php';
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