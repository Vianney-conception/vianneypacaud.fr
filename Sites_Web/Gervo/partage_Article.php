<style>
    #ZoneDeDepot {
        min-height: 300px;
        max-width: 800px;
        width: 100%;
        border: dashed 3px var(--bleuModeClaire);
        border-radius: 0.5rem;
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: unset;
    }

    #ZoneDeDepot:hover,
    #ZoneDeDepot:focus-visible {
        border: dashed 3px var(--vertModeClaire);
        outline: unset;
        background-color: var(--fondModeClaire);
    }

    #ZoneDeDepot:hover div p strong,
    #ZoneDeDepot:focus-visible div p strong {
        color: var(--vertModeClaire);
    }

    #ZoneDeDepot:hover div .plus svg,
    #ZoneDeDepot:focus-visible div .plus svg {
        stroke: var(--vertModeClaire);
    }

    #ZoneDeDepot div {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 2px;
    }

    #ZoneDeDepot div .plus {
        height: 50px;
        width: 50px;
        border-radius: 20rem;
        stroke: var(--bleuModeClaire);
    }

    #listeFichier {
        width: 100%;
        max-width: 800px;
        margin: auto;
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    #listeFichier .Fichier {
        width: 100%;
        height: 40px;
        border: 1px solid var(--grisFonce);
        border-radius: 0.5rem;
        display: flex;
        flex-direction: row;
        align-content: center;
        align-items: center;
        padding: 0 5px;
        box-sizing: border-box;
        justify-content: space-between;
    }

    #listeFichier .Fichier h3 {
        color: var(--grisFonce);
    }

    #listeFichier .Fichier:hover {
        border: 1px solid var(--bleuModeClaire);
    }

    #listeFichier .Fichier:hover h3 {
        color: 1px solid var(--bleuModeClaire);
    }

    .btn-bin svg path:nth-child(4),
    .btn-bin svg path:nth-child(5) {
        transform-box: view-box;
        transform-origin: 3px 6px;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .btn-bin:hover svg path:nth-child(4),
    .btn-bin:hover svg path:nth-child(5),
    .btn-bin:focus-visible svg path:nth-child(4),
    .btn-bin:focus-visible svg path:nth-child(5) {
        transform: translateY(-2px) rotate(-14deg);
    }

    @media (prefers-reduced-motion: reduce) {

        .btn-bin svg path:nth-child(4),
        .btn-bin svg path:nth-child(5) {
            transition: none;
        }
    }
</style>
<button id="ZoneDeDepot">
    <div>
        <div class="plus">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" data-lucide="plus" aria-hidden="true"
                class="lucide lucide-plus w-6 h-6">
                <path d="M5 12h14"></path>
                <path d="M12 5v14"></path>
            </svg>
        </div>
        <p style="margin:0;"><strong>Cliquez ou glissez vos fichiers</strong></p>
        <p style="margin:0;">Chiffrement AES-256 opéré par votre navigateur</p>
    </div>
</button>
<div id="listeFichier">
    <div class="Fichier">
        <h3>Ma super video.mp4</h3><button class="btn-bin"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash preview-icon">
                <path d="M10 11v6" />
                <path d="M14 11v6" />
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                <path d="M3 6h18" />
                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
            </svg></button>
    </div>
    <div class="Fichier">
        <h3>Ma super video avec un nom tr....mp4</h3><button class="btn-bin"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash preview-icon">
                <path d="M10 11v6" />
                <path d="M14 11v6" />
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                <path d="M3 6h18" />
                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
            </svg></button>
    </div>
    <div class="Fichier">
        <h3>document.pdf</h3><button class="btn-bin"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash preview-icon">
                <path d="M10 11v6" />
                <path d="M14 11v6" />
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                <path d="M3 6h18" />
                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
            </svg></button>
    </div>
</div>