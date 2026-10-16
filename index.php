<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vianney Pacaud - devloppeur web</title>
    <link rel="stylesheet" href="/styles/styles.css">
</head>

<body>
    <div id="GlobalSite">
        <header class="">
            <div class="logo">
                <img src="https://vianneypacaud.fr/img/LogoCouleur.png" alt="Logo Vianney Pacaud"
                    class="h-full w-auto object-contain"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            </div>
            <h1><strong class="Bleu">Vianney</strong> <strong class="Vert">Pacaud</strong><strong
                    class="Bleu">.</strong>
            </h1>
            <button id="MenuBurger" onclick="toggleModal('BoutonsNavigation');toggleModal('MenuBurger')"
                class="MenuBurger"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                    fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-menu-icon lucide-menu">
                    <path d="M4 5h16" class="line-top" />
                    <path d="M4 12h16" class="line-mid" />
                    <path d="M4 19h16" class="line-bot" />
                </svg></button>
            <nav id="BoutonsNavigation"><a id="btnApropos" class="animation" href="#A_proposRepere">À PROPOS</a><a
                    class="animation" id="btnProjet" href="#Projet">PROJETS</a><a class="animation"
                    href="/Client/">ESPACE CLIENT</a><a class="animation" id="btnContact" href="#Contact">CONTACT</a>
            </nav>
        </header>
        <div id="" style="height: 100px;"></div>
        <section id="Entete">
            <div class="text">
                <div class="titre">
                    <h1 class="Bleu">Vianney</h1>
                    <h1 class="Degrade">Pacaud</h1>
                </div>
                <p>Architecte du web moderne. Je conçois et développe des solutions numériques complètes et sur mesure.
                </p>
            </div>
            <div class="illustration">
                <div class="BoiteCodeInteractif glass-box">
                    <div class="onglet">
                        <button id="ButtonPythonExemple"
                            onclick="toggleModal('PythonExemple');toggleModal('ButtonPythonExemple');toggleModal('JavaScriptExemple');toggleModal('ButtonJavaScriptExemple')"
                            class="glass-box on">
                            <svg version="1.1" viewBox="0 0 141 131" xmlns="http://www.w3.org/2000/svg">
                                <g fill="#0ea5e9">
                                    <path
                                        d="m60.55 12.63c8.06-1.49 16.34-1.28 24.47-0.53 6.23 0.5 12.79 4.48 14.09 10.96 0.71 5.95 0.12 11.96 0.31 17.94-0.09 3.94 0.37 7.95-0.48 11.83-1.31 4.86-5.74 9.04-10.91 9.21-8.98 0.38-17.98-0.14-26.96 0.19-6.56 0.4-12.61 5.21-14.24 11.61-1.02 4.95-0.34 10.07-0.61 15.09-4.73-0.16-9.76 0.94-14.26-0.94-5.38-2.74-7.32-9.01-8.4-14.52-2.06-8.86-1.24-18.34 2.24-26.74 2.37-5.5 8.38-8.55 14.18-8.66 11.42-0.13 22.84 0.11 34.27-0.09-0.02-0.7-0.06-2.11-0.08-2.81-8.32-0.14-16.65 0.17-24.96-0.15 0.08-4.79-0.52-9.67 0.45-14.41 1.27-4.85 6.37-7.13 10.89-7.98m-1.22 6.77c-4.16 0.73-4.92 6.75-1.33 8.72 2.82 2.02 7.06-0.77 6.75-4.11 0.28-2.84-2.74-5.19-5.42-4.61z" />
                                    <path
                                        d="m103.68 38.08c5.9 0.02 13.14-1.22 17.59 3.65 4.35 5.39 5.46 12.59 6.18 19.28 0.67 8.01-1.02 16.32-5.23 23.21-1.66 2.88-4.8 4.84-8.17 4.76-12.81 0.11-25.62-0.07-38.44 0.05 0.02 0.8 0.06 2.4 0.07 3.2 8.3 0.19 16.6-0.08 24.9 0.13-0.28 5.13 1.14 10.85-1.76 15.46-3.35 4.46-8.87 6.66-14.19 7.71-9.72 1.87-20.44 1.19-28.99-4.17-3.54-2.16-5.47-6.26-5.36-10.35-0.02-7.68-0.12-15.36 0.05-23.04 0-6.36 5.31-12.32 11.75-12.58 8.64-0.34 17.31 0.09 25.96-0.13 7.53 0.09 14.28-6.34 15.26-13.67 0.51-4.49 0.2-9.01 0.38-13.51m-16.24 61.2c-3.96 1.7-2.75 8.7 1.63 8.78 3.62 0.72 6.15-3.53 4.66-6.62-0.81-2.56-4.09-3-6.29-2.16z" />
                                </g>
                            </svg> Vianney.py
                        </button>
                        <button id="ButtonJavaScriptExemple" class="glass-box"
                            onclick="toggleModal('PythonExemple');toggleModal('ButtonPythonExemple');toggleModal('JavaScriptExemple');toggleModal('ButtonJavaScriptExemple')">
                            <svg viewBox="0 0 422 421" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M279.285 205.49C307.067 181.639 359.933 186.369 374.657 222.746C365.929 229.042 356.935 234.938 347.441 240.035C340.312 233.839 333.617 225.111 323.39 224.678C313.563 223.745 301.238 229.575 301.371 240.768C299.405 252.593 310.298 260.355 319.826 264.319C339.379 272.481 360.333 279.943 375.156 295.832C388.381 310.19 389.18 332.009 384.284 349.998C378.654 369.852 359.167 382.311 339.646 385.509C306.701 390.772 266.893 379.979 251.67 347.666C261.13 341.27 271.091 335.64 281.117 330.177C288.879 338.039 296.507 347.066 307.5 350.331C319.059 354.695 333.383 354.195 343.144 346.034C351.438 339.305 351.572 324.614 342.511 318.451C323.823 304.893 299.838 300.563 281.983 285.606C258.132 266.551 256.633 226.11 279.285 205.49Z"
                                    fill="white" />
                                <path
                                    d="M191.276 194.097C203.934 193.631 216.626 193.564 229.251 194.364C228.885 237.436 229.184 280.542 229.084 323.648C228.918 341.537 225.42 361.457 211.163 373.749C193.974 388.573 168.724 389.206 147.737 383.41C131.281 379.313 119.156 366.221 111.927 351.397C121.788 345.068 131.614 338.605 142.541 334.208C148.637 341.77 155.399 350.298 165.692 351.797C174.487 354.662 185.513 350.598 188.511 341.403C191.009 332.342 191.142 322.849 191.376 313.521C191.342 273.713 191.276 233.905 191.276 194.097Z"
                                    fill="white" />
                                <path
                                    d="M0.39974 0.420654C140.675 -0.145652 280.984 -0.145651 421.26 0.453967C421.793 140.298 421.793 280.209 421.26 420.053C280.984 420.653 140.675 420.653 0.39974 420.053C-0.133247 280.176 -0.133247 140.298 0.39974 0.420654ZM279.285 205.49C256.633 226.11 258.132 266.551 281.983 285.606C299.839 300.563 323.823 304.893 342.511 318.451C351.572 324.614 351.438 339.305 343.144 346.034C333.383 354.195 319.059 354.695 307.5 350.331C296.507 347.066 288.879 338.039 281.117 330.177C271.091 335.64 261.13 341.27 251.67 347.666C266.893 379.979 306.701 390.772 339.646 385.509C359.167 382.311 378.654 369.852 384.284 349.998C389.181 332.009 388.381 310.19 375.156 295.832C360.333 279.943 339.38 272.481 319.826 264.319C310.298 260.355 299.405 252.593 301.371 240.768C301.238 229.575 313.563 223.745 323.39 224.678C333.617 225.111 340.312 233.839 347.441 240.035C356.935 234.938 365.929 229.042 374.657 222.746C359.933 186.369 307.067 181.638 279.285 205.49ZM191.276 194.097C191.276 233.905 191.342 273.713 191.376 313.521C191.142 322.849 191.009 332.342 188.511 341.403C185.513 350.598 174.487 354.662 165.692 351.797C155.399 350.298 148.637 341.77 142.541 334.208C131.614 338.605 121.788 345.068 111.927 351.397C119.156 366.221 131.281 379.313 147.737 383.41C168.724 389.206 193.974 388.573 211.163 373.749C225.42 361.457 228.918 341.537 229.085 323.648C229.184 280.542 228.885 237.436 229.251 194.364C216.626 193.564 203.934 193.631 191.276 194.097Z"
                                    fill="#EAB308" />
                            </svg> Outils.js
                        </button>
                    </div>
                    <div class="text">
                        <pre id="PythonExemple" class="on"
                            style="color: #24292e; padding: 15px; border-radius: 5px; font-family: 'Courier New', Courier, monospace; line-height: 1.5;"><code><span style="color: #d73a49;">class</span> <span style="color: #6f42c1;">Developer</span>:
            <span style="color: #d73a49;">def</span> <span style="color: #6f42c1;">__init__</span>(<span style="color: #e36209;">self</span>):
                <span style="color: #e36209;">self</span>.name = <span style="color: #032f62;">"Vianney Pacaud"</span>
                <span style="color: #e36209;">self</span>.stack = [<span style="color: #032f62;">"PHP"</span>, <span style="color: #032f62;">"JS"</span>, <span style="color: #032f62;">"Python"</span>, <span style="color: #032f62;">"SQL"</span>]
                <span style="color: #e36209;">self</span>.ambition = <span style="color: #032f62;">"Build clean tech"</span>

                <span style="color: #d73a49;">def</span> <span style="color: #6f42c1;">get_status</span>(<span style="color: #e36209;">self</span>):
                     <span style="color: #d73a49;">return</span> <span style="color: #032f62;">"Ready to innovate"</span>

                    <span style="color: #6a737d;"># Let's execute</span>
            <span style="color: #0052cc;">print</span>(Developer().get_status())
<span style="color: #6a737d;">>>> "Ready to innovate"</span></code></pre>
                        <pre class="JavaScriptExemple" id="JavaScriptExemple" color: #24292e; padding: 15px;
                            border-radius: 5px; font-family: 'Courier New' , Courier, monospace; line-height: 1.5;"><code><span style="color: #d73a49;">const</span> <span style="color: #6f42c1;">gervoOutils</span> = {
    <span style="color: #0052cc;">type</span>: <span style="color: #032f62;">"Boîte à outils locale"</span>,
    <span style="color: #0052cc;">security</span>: <span style="color: #032f62;">"100% Client-Side"</span>,
    <span style="color: #0052cc;">features</span>: [
        <span style="color: #032f62;">"Convertisseur d'image"</span>,
        <span style="color: #032f62;">"Partage fichiers lourds"</span>,
        <span style="color: #032f62;">"Générateur QR Code"</span>
    ],
    <span style="color: #6f42c1;">run</span>: () =&gt; {
        <span style="color: #e36209;">console</span>.<span style="color: #6f42c1;">log</span>(<span style="color: #032f62;">"Zéro donnée partagée"</span>);
    }
};</code></pre>
                    </div>
                </div>
            </div>
        </section>
        <div id="A_proposRepere"></div>
        <section style="flex-direction: column;" id="A_propos">
            <div class="Seperation"></div>
            <div class="apropos-contenu">
                <div class="philosophie-scroll-zone" id="ZoneScrollLaptop">

                    <div class="text titre-sticky-independant">
                        <div class="titre">
                            <h1>À propos de moi</h1>
                            <p>Une vision moderne de l'ingénierie web.</p>
                        </div>
                    </div>
                    <div class="philosophie-sticky-content glass-box box-animee Animation" id="MaPhilosophie">
                        <div class="philosophie-texte">
                            <h3>MA PHILOSOPHIE</h3>
                            <h1>Transformer la complexité en simplicité élégante</h1>
                            <br>
                            <p>Développeur curieux et hautement polyvalent, je façonne des expériences numériques
                                complètes. De la structure backend à l'habillage sémantique en passant par la
                                fluidité des interactions, je privilégie la clarté et la durabilité du code.</p>
                            <br>
                            <p>Mon leitmotiv : une conception sans fioriture, centrée sur l'utilisateur, que ce soit
                                pour des utilitaires locaux sécurisés ou des architectures e-commerce performantes.
                            </p>
                        </div>

                        <div class="philosophie-laptop">
                            <canvas id="laptop-canvas"></canvas>
                        </div>
                    </div>

                </div>
            </div>
            <div class="Animation glass-box box-animee" id="Lesoucisdudetail">
                <div class="Lesoucisdudetail-texte">
                    <h3>LE SOUCI DU DÉTAIL</h3>
                    <h1>Chaques détail compte !</h1>
                    <br>
                    <p>
                        L'image à son importance ! Chaques effet attire le regard de vos visiteurs sur ce qui est
                        <span class="battementCoeur">important</span>.
                    </p>
                    <br>
                </div>
            </div>
        </section>

        <section style="flex-direction: column;" id="Projets">
            <div class="Seperation"></div>
            <div class="apropos-contenu">

                <div class="text titre-sticky-independant">
                    <div class="titre" id="Projet">
                        <h1>Mes Projets</h1>
                        <p>Découvrez quelques-uns de mes projets</p>
                    </div>
                </div>

                <div class="philosophie-sticky-content glass-box box-animee Animation" id="GervoDetour">
                    <div class="philosophie-texte" style="width: 100%;">
                        <h3 style="margin: 0;">CREATION D'UNE API</h3>
                        <h1 style="margin-top : 3px;">Deploiment d'une api de détourage d'images.</H1>
                        <p>J'ai déployé cette solution à partir de modèles de détourage open source tels que U2-Net. L'image est traitée sur la mémoire RAM et n'est donc pas enregistrée. 
                            <?php
                            $ch = curl_init('https://detour.api.gervo.fr/health');
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
                            $response = curl_exec($ch);
                            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                            curl_close($ch);
                            $data = $response ? json_decode($response, true) : null;
                            if ($httpCode === 200 && isset($data['status']) && $data['status'] === 'available') {
                                echo '';
                            } ?></p>
                    </div>
                    <div class="DemoGervoDetourAPI">
                        <div class="img-comparator" id="comparator">
                            <img src="/img/exempleDetour.webp" alt="Détouré" class="img-cut">
                            <img src="/img/exempleNonDetour.webp" alt="Non détouré" class="img-full" id="imgFull">
                            <div class="comparator-slider" id="sliderBar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div style="height: 800px;"></div>

    </div>
    <script src="/JS/fond.js"></script>
    <script src="/JS/scroll.js"></script>
    <script src="/JS/modal.js"></script>
    <script src="/JS/anime.js"></script>
    <script src="/JS/detour.js"></script>
</body>

</html>