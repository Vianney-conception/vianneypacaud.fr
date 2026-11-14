<style>
    #SommaireArticle {
        display: none;
    }

    article {
        background-color: unset;
        border: none;
    }

    .carte {
        margin: auto;
        background-color: var(--blanc);
        border: 1px solid var(--grisNuance2);
        padding: 20px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        border-radius: 0.5rem;
        gap: 0;
        transition: filter 0.3s ease;
    }

    a.carte {
        width: 90%;
        max-width: 400px;
        height: 200px;
        background-image: unset;
        margin: 0;
        display: flex;
        flex-direction: column;
        transition: ease all 0.3s;
        box-shadow: unset;
        gap: 5px;
    }

    a.carte:hover,
    a.carte:focus {
        box-shadow: var(--ombreMoyenne);
        outline: none;
    }

    a.carte:hover h3,
    a.carte:focus h3 {
        color: var(--vertModeClaire);
    }

    .EnsembleCarte {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        flex-direction: row;
        justify-content: center;
    }

    a.carte h3,
    a.carte p {
        margin: 0;
    }

    a.carte .logoCarteAPP {
        background-color: var(--fondModeClaire);
        border-radius: 0.5rem;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
    }

    a.carte .logoCarteAPP svg {
        stroke: var(--bleuModeClaire);
        transition: stroke ease 0.3s;
    }

    a.carte:hover .logoCarteAPP svg {
        stroke: var(--vertModeClaire);
    }

    a.carte .lien {
        display: flex;
        color: var(--bleuModeClaire);
        margin-top: 5px;
        background-image: linear-gradient(var(--vertModeClaire), var(--vertModeClaire));
        background-size: 0% 2px;
        background-repeat: no-repeat;
        background-position: left bottom;
        transition: background-size 0.4s linear;
        text-decoration: none;
        width : 84px;
    }

    a.carte:hover .lien,
    a.carte:focus .lien {
        color: var(--vertModeClaire);
        background-size: 100% 2px;
    }
</style>
<div class="" style="display: flex;flex-direction: column;align-items: center;padding: 30px">
    <h1 style="Margin-bottom: 1px;font-size:2.5rem">Tous vos outils, au même endroit.</h1>
    <h3 style="color:var(--grisNuance3); margin-bottom: 60px">Des solutions simples, sans publicité et qui respectent
        votre vie privée. Le
        traitement de vos données s'effectue directement dans votre navigateur.</h3>
</div>
<div class="EnsembleCarte">
    <!-- 1. Gervo Partage -->
    <a class="carte" href="https://partage.gervo.fr/">
        <div class="logoCarteAPP">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" height="24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="24" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.714 3.048a.498.498 0 0 0-.683.627l2.843 7.627a2 2 0 0 1 0 1.396l-2.842 7.627a.498.498 0 0 0 .682.627l18-8.5a.5.5 0 0 0 0-.904z"></path>
                <path d="M6 12h16"></path>
            </svg>
        </div>
        <h3>Gervo Partage</h3>
        <p>Partagez vos fichiers de manière sécurisée. Générez un lien de partage privé valable 30 jours pour vos documents volumineux.</p>
        <p class="lien">Ouvrir l'outil</p>
    </a>

    <!-- 2. Detour -->
    <a class="carte" href="https://detour.gervo.fr/">
        <div class="logoCarteAPP">
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-route preview-icon"><path d="M9 5h8.5a1 1 0 010 7h-11a1 1 0 000 7H15"/><circle cx="18" cy="19" r="3"/><circle cx="6" cy="5" r="3"/></svg>
        </div>
        <h3>Detour</h3>
        <p>Supprimez le fond de vos images en utilisant les meilleurs modèles de détourage open source.</p>
        <p class="lien">Ouvrir l'outil</p>
    </a>

    <!-- 3. Gervo QR Code -->
    <a class="carte" href="https://qr-code.gervo.fr/">
        <div class="logoCarteAPP">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-6 w-6" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                <rect height="18" width="18" x="3" y="3" rx="2"></rect>
                <path d="M7 7h.01"></path>
                <path d="M17 7h.01"></path>
                <path d="M7 17h.01"></path>
                <path d="M17 17h.01"></path>
            </svg>
        </div>
        <h3>Gervo QR Code</h3>
        <p>Générez des QR Codes statiques personnalisés (URL, Texte, vCard, wifi) sans redirection et gratuits à vie.</p>
        <p class="lien">Ouvrir l'outil</p>
    </a>

    <!-- 4. Gervo PDF -->
    <a class="carte" href="https://pdf.gervo.fr/">
        <div class="logoCarteAPP">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-6 w-6" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" x2="8" y1="13" y2="13"></line>
                <line x1="16" x2="8" y1="17" y2="17"></line>
                <line x1="10" x2="8" y1="9" y2="9"></line>
            </svg>
        </div>
        <h3>Gervo PDF (version web)</h3>
        <p>Manipulez vos fichiers PDF : fusion, division ou compression. Travaillez en toute sécurité sans envoyer vos fichiers sur un serveur.</p>
        <p class="lien">Ouvrir l'outil</p>
    </a>

    <!-- 5. Gervo Bascule -->
    <a class="carte" href="https://bascule.gervo.fr/">
        <div class="logoCarteAPP">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-6 w-6" stroke-width="2" xmlns="http://www.w3.org/2000/svg" stroke-linecap="round" stroke-linejoin="round" height="24" width="24">
                <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                <path d="M3 3v5h5"></path>
                <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"></path>
                <path d="M16 16h5v5"></path>
                <circle cx="12" cy="12" r="1"></circle>
            </svg>
        </div>
        <h3>Gervo Bascule</h3>
        <p>Convertissez vos images instantanément dans différents formats (PNG, JPG, WebP) sans perte de qualité et 100% localement.</p>
        <p class="lien">Ouvrir l'outil</p>
    </a>

    <!-- 6. Gervo OCR -->
    <a class="carte" href="https://ocr.gervo.fr/">
        <div class="logoCarteAPP">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-6 w-6" stroke-width="2" xmlns="http://www.w3.org/2000/svg" stroke-linecap="round" stroke-linejoin="round" height="24" width="24">
                <path d="M3 7V5a2 2 0 0 1 2-2h2"></path>
                <path d="M17 3h2a2 2 0 0 1 2 2v2"></path>
                <path d="M21 17v2a2 2 0 0 1-2 2h-2"></path>
                <path d="M7 21H5a2 2 0 0 1-2-2v-2"></path>
                <path d="M7 8h8"></path>
                <path d="M7 12h10"></path>
                <path d="M7 16h6"></path>
            </svg>
        </div>
        <h3>Gervo OCR</h3>
        <p>Extrayez le texte de vos images et documents scannés grâce à une reconnaissance optique puissante et rapide.</p>
        <p class="lien">Ouvrir l'outil</p>
    </a>

    <!-- 7. Gervo Chiffrement -->
    <a class="carte" href="https://chiffrement.gervo.fr/">
        <div class="logoCarteAPP">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-6 w-6" stroke-width="2" xmlns="http://www.w3.org/2000/svg" stroke-linecap="round" stroke-linejoin="round" height="24" width="24">
                <rect height="11" width="18" x="3" y="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
        </div>
        <h3>Gervo Chiffrement</h3>
        <p>Chiffrez et déchiffrez vos fichiers en toute sécurité grâce à l'algorithme AES-256. Vos données ne quittent jamais votre ordinateur.</p>
        <p class="lien">Ouvrir l'outil</p>
    </a>
    
</div>