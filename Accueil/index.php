<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vianney Pacaud - Accueil</title>
    <link rel="stylesheet" href="../css/styles.css">
    <?php include '../facivon/index.php'; ?>
</head>

<body class="Claire">
    <?php include '../header/index.php'; ?>

    <div class="containerClassique">
        <img class="Portrait" src="../img/Vianney_PacaudT.webp" alt="">
        <div class="text">
            <div class="citation">
                <h1>Bonjour,</h1>
                <p>Je m'appelle Vianney. Étant passionné par l'informatique et tout particulièrement par le développement web, je propose de vous accompagner tout au long de votre projet. Ne vous inquiétez plus, je m'occupe de tout ! De votre site web aux services de messagerie, vous pouvez compter sur moi.</p>
            </div>
        </div>
    </div>
    </div>

    <div style="justify-content: space-between;" class="containerClassique">
        <h2>CV :</h2>
        <a class="btn" href="/CV/" target="_blank">
            <svg style="margin-right: 5px;" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h560v-280h80v280q0 33-23.5 56.5T760-120H200Zm188-212-56-56 372-372H560v-80h280v280h-80v-144L388-332Z" />
            </svg> Voir le CV</a>

    </div>


    <div class="containerClassique">
        <div style="display: flex; flex-direction: column; width: 100%;">
            <h1>Langages pratiqués</h1>
            <div class="langages">

                <div class="Langue"><img src="/img/html.svg" id="html" alt=""><p>HTML</p></div>
                <div class="Langue"><img src="/img/css.svg" id="CSS" alt=""><p>CSS</p></div>
                <div class="Langue"><img src="/img/php.svg" id="PHP" alt=""><p>PHP</p></div>
                <div class="Langue"><img src="/img/js.svg" id="JS" alt=""><p>JavaScript</p></div>
                <div class="Langue"><img src="/img/python.svg" id="Python" alt=""><p>Python</p></div>
                <div class="Langue"><img src="/img/C++.svg" id="C" alt=""><p>C++</p></div>
            </div>
        </div>
    </div>
    <?php include '../footer/index.php'; ?>

</body>
<script src="/Scripts/MoteurRendu.js"></script>
<script src="/Scripts/Langages.js"></script>
<script src="/Scripts/cookie.js"></script>

</html>