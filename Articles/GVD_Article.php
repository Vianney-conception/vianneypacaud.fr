<h1>GESTION DE VOS DONNÉES</h1>
<div class="info banal">Dernière modification le 30/10/2026</div>
<h2>ARTICLE 1 - DONNÉES RELATIVES À LA VISITE DE CE SITE</h2>
<p>Liste des données pouvant être recueillies :</p>
<ul>
    <li><strong>Votre adresse IP</strong> : <?php 
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        echo $ip;
    ?></li>

    <li><strong>Port distant</strong> : <?php echo $_SERVER['REMOTE_PORT'] ?? 'Non disponible'; ?></li>
    <li><strong>Protocole HTTP</strong> : <?php echo $_SERVER['SERVER_PROTOCOL'] ?? 'Non disponible'; ?></li>
    <li><strong>Page de provenance (Referrer)</strong> : <?php echo !empty($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : 'Aucune'; ?></li>
    <li><strong>En-tête Accept-Language</strong> : <?php echo $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'Non disponible'; ?></li>
    <li><strong>User-Agent (brut)</strong> : <?php echo htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? 'Non disponible'); ?></li>
    <li><strong>Votre navigateur</strong> : <span id="navigateur-client">Chargement...</span></li>
    <li><strong>Système d'exploitation</strong> : <span id="os-client">Chargement...</span></li>
    <li><strong>Résolution d'écran</strong> : <span id="resolution-ecran">Chargement...</span></li>
    <li><strong>Taille de la fenêtre (Viewport)</strong> : <span id="taille-fenetre">Chargement...</span></li>
    <li><strong>Profondeur de couleur</strong> : <span id="profondeur-couleur">Chargement...</span></li>
    <li><strong>Langue du navigateur</strong> : <span id="langue-navigateur">Chargement...</span></li>
    <li><strong>Fuseau horaire</strong> : <span id="fuseau-horaire">Chargement...</span></li>
    <li><strong>Cœurs du processeur (Threads)</strong> : <span id="cpu-cores">Chargement...</span></li>
    <li><strong>Mémoire vive estimée</strong> : <span id="ram-device">Chargement...</span></li>
</ul>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function obtenirNavigateur() {
            if (navigator.userAgentData && navigator.userAgentData.brands) {
                const marqueValide = navigator.userAgentData.brands.find(b => !b.brand.includes("Not") && !b.brand.includes("Chromium"));
                if (marqueValide) {
                    let nom = marqueValide.brand;
                    if (nom.includes("Edg")) return "Microsoft Edge";
                    if (nom.includes("Chrome")) return "Google Chrome";
                    if (nom.includes("Opera")) return "Opera";
                    if (nom.includes("Brave")) return "Brave";
                    return nom;
                }
            }
            const ua = navigator.userAgent;
            if (ua.indexOf("Firefox") > -1) return "Mozilla Firefox";
            if (ua.indexOf("SamsungBrowser") > -1) return "Samsung Internet";
            if (ua.indexOf("Opera") > -1 || ua.indexOf("OPR") > -1) return "Opera";
            if (ua.indexOf("Trident") > -1) return "Internet Explorer";
            if (ua.indexOf("Edge") > -1 || ua.indexOf("Edg/") > -1) return "Microsoft Edge";
            if (ua.indexOf("Chrome") > -1) return "Google Chrome";
            if (ua.indexOf("Safari") > -1) return "Apple Safari";
            return "Navigateur inconnu";
        }
        document.getElementById("navigateur-client").textContent = obtenirNavigateur();
        function obtenirOS() {
            if (navigator.userAgentData && navigator.userAgentData.platform) {
                return navigator.userAgentData.platform;
            }
            const ua = navigator.userAgent;
            if (ua.indexOf("Win") > -1) return "Windows";
            if (ua.indexOf("Mac") > -1) return "MacOS";
            if (ua.indexOf("Linux") > -1) return "Linux";
            if (ua.indexOf("Android") > -1) return "Android";
            if (ua.indexOf("like Mac") > -1) return "iOS";
            return "Inconnu";
        }
        document.getElementById("os-client").textContent = obtenirOS();
        document.getElementById("resolution-ecran").textContent = window.screen.width + " x " + window.screen.height + " pixels";
        document.getElementById("taille-fenetre").textContent = window.innerWidth + " x " + window.innerHeight + " pixels";
        document.getElementById("profondeur-couleur").textContent = window.screen.colorDepth + " bits";
        document.getElementById("langue-navigateur").textContent = navigator.language || navigator.userLanguage || "Inconnue";
        try {
            document.getElementById("fuseau-horaire").textContent = Intl.DateTimeFormat().resolvedOptions().timeZone;
        } catch(e) {
            document.getElementById("fuseau-horaire").textContent = "Non disponible";
        }
        document.getElementById("cpu-cores").textContent = navigator.hardwareConcurrency ? navigator.hardwareConcurrency + " cœurs" : "Non disponible";
        document.getElementById("ram-device").textContent = navigator.deviceMemory ? "~" + navigator.deviceMemory + " Go" : "Non disponible";
    });
</script>
<h3>Que faisons-nous de ces données ?</h3>
<p>Ces données techniques sont collectées uniquement dans votre intérêt pour le bon fonctionnement du site. Elles permettent d'adapter automatiquement l'affichage à la taille de votre écran (que vous soyez sur mobile, tablette ou ordinateur), de garantir la compatibilité avec votre navigateur et de vous offrir une navigation fluide et sécurisée. <strong>Vos données</strong> restent <strong>strictement confidentielles</strong> : elles ne sont <strong>ni revendues</strong>, <strong>ni utilisées à des fins commerciales</strong> ou de profilage</strong>.
</p>

<h2>ARTICLE 2 - DONNÉES RELATIVES À L'USAGE DE NOS API</h2>
<p>
    Lorsque vous utilisez nos API (telles que notre moteur de détourage d'image), l'ensemble du traitement est effectué exclusivement de manière éphémère <strong>dans la mémoire vive (RAM)</strong> de nos serveurs. Aucune donnée transmise ou traitée par nos services n'est stockée sur disque. Par exemple, si vous soumettez une image à notre outil de détourage, celle-ci est traitée instantanément en mémoire, puis <strong>détruite immédiatement</strong> dès que le résultat vous est renvoyé.
</p>
<p>
    Seul <strong>le nombre d'appels</strong> effectués par clé d'API ou par service est conservé à des fins de suivi d'utilisation et de bon fonctionnement.
</p>

<h2>ARTICLE 3 - DONNÉES RELATIVES AUX PRESTATIONS :</h2>
<p>Pour ces données, consultez les <a href="/Articles/CGV">CGV</a>.</p>

<h2>ARTICLE 4 - VOS DROITS ET RESPECT DU RGPD</h2>
<p>
    Conformément au <strong>Règlement Général sur la Protection des Données (RGPD)</strong> et à la réglementation européenne en vigueur, vous disposez d'un contrôle total sur vos données personnelles. Vous pouvez exercer à tout moment les droits suivants :
</p>
<ul>
    <li><strong>Droit d'accès :</strong> Obtenir la confirmation que vos données sont traitées et en recevoir une copie.</li>
    <li><strong>Droit de rectification :</strong> Demander la correction de données inexactes ou incomplètes vous concernant.</li>
    <li><strong>Droit à l'effacement (« droit à l'oubli ») :</strong> Demander la suppression définitive de vos données personnelles sous réserve des obligations légales de conservation.</li>
    <li><strong>Droit à la limitation du traitement :</strong> Demander le gel temporaire du traitement de vos données dans certains cas spécifiques.</li>
    <li><strong>Droit à la portabilité :</strong> Récupérer les données que vous nous avez fournies dans un format structuré et lisible par machine.</li>
    <li><strong>Droit d'opposition :</strong> Vous opposer à tout moment au traitement de vos données pour des motifs légitimes.</li>
</ul>
<p>
    Pour faire valoir l'un de ces droits ou pour toute question relative à la protection de vos données, vous pouvez nous contacter directement via notre <a href="/#Contact">formulaire de contact</a>.
</p>