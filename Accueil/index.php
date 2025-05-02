<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vianney Pacaud - Acceuil</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../img/Logo_N&B.png" type="image/x-icon">
</head>

<body>
    <?php include '../header/index.php'; ?>

    <div class="containerClassique">
        <img class="Portrait" src="../img/Vianney_PacaudT.webp" alt="">
        <div class="text">
            <div class="citation">
                <h1>Bonjour,</h1>
                <p>Je m'appelle Vianney, étant passionné par l'informatique et tout particulièrement par le développement web, je propose de vous accompagner tout au long de votre projet. Ne vous inquiétez plus, je m'occupe de tout ! De votre site Web aux services de messagerie, vous pouvez compter sur moi </p>
            </div>
        </div>
    </div>
    </div>

    <div style="justify-content: space-between;" class="containerClassique">
        <h2>CV :</h2>
        <a class="btn" href="/CV/" target="_blank">
            <svg style="margin-right: 5px;" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h560v-280h80v280q0 33-23.5 56.5T760-120H200Zm188-212-56-56 372-372H560v-80h280v280h-80v-144L388-332Z" />
            </svg> Voire le CV</a>

    </div>


    <div class="containerClassique">
        <div style="display: flex; flex-direction: column; width: 100%;">
            <h1>Langages pratiquer</h1>
            <div class="langages">

                <div class="Langue"><img src="/img/html.svg" id="html" alt=""><p>html</p></div>
                <div class="Langue"><img src="/img/css.svg" id="CSS" alt=""><p>css</p></div>
                <div class="Langue"><img src="/img/php.svg" id="PHP" alt=""><p>PHP</p></div>
                <div class="Langue"><img src="/img/js.svg" id="JS" alt=""><p>JS</p></div>
                <div class="Langue"><img src="/img/python.svg" id="Python" alt=""><p>Python</p></div>
                <div class="Langue"><img src="/img/C++.svg" id="C" alt=""><p>C++</p></div>
            </div>
        </div>
    </div>

</body>
<script src="/Scripts/MoteurRendu.js"></script>
<script>

document.querySelectorAll('.Langue').forEach(langue => {
    langue.addEventListener('mouseover', (event) => {
        const descriptions = {
            html: {
                text: "HTML est utilisé pour structurer le contenu des pages web.",
                img: "images/htmlilustre.gif"
            },
            CSS: {
                text: "CSS est utilisé pour styliser et mettre en page les sites web.",
                img: "images/cssilustre.gif"
            },
            PHP: {
                text: "PHP est un langage serveur pour créer des sites dynamiques.",
                img: "images/phpilustre.gif"
            },
            JS: {
                text: "JavaScript permet d'ajouter des interactions aux pages web.",
                img: "images/jsilustre.gif"
            },
            Python: {
                text: "Python est polyvalent, utilisé pour le web, la data et plus.",
                img: "images/pythonilustre.gif"
            },
            C: {
                text: "C++ est utilisé pour les logiciels performants et pour la programmation de microcontrôleurs, je l'utilise pour fabriquer des petites machines.",
                img: "images/cppilustre.gif"
            }
        };

        const id = langue.querySelector('img').id;
        const data = descriptions[id] || { text: "Description non disponible.", img: "" };

        const tooltip = document.createElement('div');
        tooltip.className = 'containerClassique tooltip';
        tooltip.style.position = 'absolute';
        tooltip.style.width = '220px';
        tooltip.style.backgroundColor = '#333';
        tooltip.style.color = '#fff';
        tooltip.style.padding = '10px';
        tooltip.style.borderRadius = '5px';
        tooltip.style.fontSize = '12px';
        tooltip.style.pointerEvents = 'none';
        tooltip.style.top = `${event.pageY + 10}px`;
        tooltip.style.left = `${event.pageX + 10}px`;
        tooltip.style.textAlign = 'center';

        if (data.img) {
            const image = document.createElement('img');
            image.src = data.img;
            image.alt = id;
            image.style.width = '40px';
            image.style.height = '40px';
            image.style.display = 'block';
            image.style.margin = '0 auto 8px auto';
            tooltip.appendChild(image);
        }

        const texte = document.createElement('div');
        texte.textContent = data.text;
        tooltip.appendChild(texte);

        document.body.appendChild(tooltip);

        langue.addEventListener('mousemove', (e) => {
            tooltip.style.top = `${e.pageY + 10}px`;
            tooltip.style.left = `${e.pageX + 10}px`;
        });

        langue.addEventListener('mouseout', () => {
            tooltip.remove();
        });
    });
});


</script>

</html>