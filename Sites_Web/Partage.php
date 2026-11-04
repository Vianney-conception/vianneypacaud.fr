<?php
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$baseUrl = '/';
$isArticleDir = (stripos($requestUri, '/Articles/') !== false || preg_match('#^/Articles/?$#i', $requestUri));

if ($isArticleDir) { ?>
<meta property=og:type content=website>
    <meta property=og:url content="https://vianneypacaud.fr/">
    <meta property=og:site_name content="Vianney Pacaud">
    <meta property=og:title content="<?php if (isset($config[$article_cible])) {
        echo $config[$article_cible].' - Vianney Pacaud';
    } else {
        echo "Article introuvable";
    } ?>">
    <meta property=og:description
        content="<?php if (isset($config[$article_cible])) {
        echo $Resume[$article_cible];
    } else {
        echo "Article introuvable";
    } ?>">
    <meta property=og:image content="https://vianneypacaud.fr/img/LogoArticle.jpg">
    <meta property=og:locale content=fr_FR>
    <meta name=twitter:card content=summary_large_image>
    <meta name=twitter:url content="https://vianneypacaud.fr/">
    <meta name=twitter:title content="<?php if (isset($config[$article_cible])) {
        echo $config[$article_cible].' - Vianney Pacaud';
    } else {
        echo "Article introuvable";
    } ?>">
    <meta name=twitter:description
        content="<?php if (isset($config[$article_cible])) {
        echo $Resume[$article_cible];
    } else {
        echo "Article introuvable";
    } ?>">
    <meta name=twitter:image content="https://vianneypacaud.fr/img/LogoArticle.jpg">
    
    <?php
} else {
    ?>
    <meta property=og:type content=website>
    <meta property=og:url content="https://vianneypacaud.fr/">
    <meta property=og:site_name content="Vianney Pacaud">
    <meta property=og:title content="Vianney Pacaud — Devellopeur web">
    <meta property=og:description
        content="Architecte du web moderne. Je conçois et développe des solutions numériques complètes et sur mesure.">
    <meta property=og:image content="https://vianneypacaud.fr/img/PortraitFondNoirMP.jpg">
    <meta property=og:locale content=fr_FR>
    <meta name=twitter:card content=summary_large_image>
    <meta name=twitter:url content="https://vianneypacaud.fr/">
    <meta name=twitter:title content="Vianney Pacaud">
    <meta name=twitter:description
        content="Architecte du web moderne. Je conçois et développe des solutions numériques complètes et sur mesure.">
    <meta name=twitter:image content="https://vianneypacaud.fr/img/PortraitFondNoirMP.jpg">
    <?php
}
?>