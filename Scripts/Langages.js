
document.querySelectorAll('.Langue').forEach(langue => {
    langue.addEventListener('mouseover', (event) => {
        const descriptions = {
            html: "HTML est utilisé pour structurer le contenu des pages web.",
            CSS: "CSS est utilisé pour styliser et mettre en page les sites web.",
            PHP: "PHP est un langage serveur pour créer des sites dynamiques.",
            JS: "JavaScript permet d'ajouter des interactions aux pages web.",
            Python: "Python est polyvalent, utilisé pour le web, la data et plus.",
            C: "C++ est utilisé pour les logiciels performants et pour la programation de microcontroleur microcontrôleurs, je l'utilise pour fabriquer des petites machines."
        };

        const id = langue.querySelector('img').id;
        const description = descriptions[id] || "Description non disponible.";

        
        const tooltip = document.createElement('div');
        tooltip.className = 'containerClassique tooltip';
        tooltip.textContent = description;
        tooltip.style.position = 'absolute';
        tooltip.style.width = '200px';
        tooltip.style.backgroundColor = '#333';
        tooltip.style.color = '#fff';
        tooltip.style.padding = '10px';
        tooltip.style.borderRadius = '5px';
        tooltip.style.fontSize = '12px';
        tooltip.style.pointerEvents = 'none';
        tooltip.style.top = `${event.pageY + 10}px`;
        tooltip.style.left = `${event.pageX + 10}px`;

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