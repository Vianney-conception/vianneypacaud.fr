<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vianney Pacaud - devloppeur web</title>
    <link rel="stylesheet" href="/styles/styles.css">
    <script src="/JS/chargement.js"></script>
    <link rel="icon" href="https://vianneypacaud.fr/img/LogoCouleur.png" type="image/x-icon">
</head>

<body>
    <?php
    include 'chargement.php';
    ?>
    <div id="GlobalSite" style="display:none;">
        <?php
        include 'header.php';
        ?>
        <section id="Entete">
            <div class="text">
                <div class="titre">
                    <h1 class="Bleu">Vianney</h1>
                    <h1 class="Degrade">Pacaud</h1>
                </div>
                <p>Architecte du web moderne. Je conçois et développe des solutions numériques complètes et sur mesure.
                </p>
            </div>
            <?php
            include 'illustration.php';
            ?>
        </section>
        <div id="A_proposRepere"></div>
        <section style="flex-direction: column;" id="A_propos">
            <div class="Seperation"></div>
            <div class="apropos-contenu">
                <div class="philosophie-scroll-zone" id="ZoneScrollLaptop">

                    <div class="text titre-sticky-independant">
                        <div class="titre">
                            <h1>À propos...</h1>
                            <p>Une vision moderne de l'ingénierie web.</p>
                        </div>
                    </div>
                    <div class="philosophie-sticky-content glass-box box-animee Animation styleDivSection"
                        id="MaPhilosophie">
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
            <div class="Animation glass-box box-animee styleDivSection" id="Lesoucisdudetail">
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

                <div class="philosophie-sticky-content glass-box box-animee Animation styleDivSection" id="GervoDetour">
                    <div class="philosophie-texte" style="width: 100%;">
                        <h3 style="margin: 0;">CREATION D'UNE API</h3>
                        <h1 style="margin-top : 3px;">Deploiment d'une api de détourage d'images.</H1>
                        <p>J'ai déployé cette solution à partir de modèles de détourage open source tels que U2-Net.
                            L'image est traitée sur la mémoire RAM et n'est donc pas enregistrée.</p>
                        <?php
                        $ch = curl_init('https://detour.api.gervo.fr/health');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
                        $response = curl_exec($ch);
                        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);
                        $data = $response ? json_decode($response, true) : null;
                        if ($httpCode === 200 && isset($data['status']) && $data['status'] === 'available') {
                            echo '<button onclick="window.open(\'https://detour.gervo.fr\', \'_blank\');" style="max-width: 120px;" class="stylebtn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-external-link preview-icon"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg> Tester l\'API</button>';
                        } ?>
                    </div>
                    <div class="DemoGervoDetourAPI">
                        <div class="img-comparator" id="comparator">
                            <img src="/img/exempleDetour.webp" alt="Détouré" class="img-cut">
                            <img src="/img/exempleNonDetour.webp" alt="Non détouré" class="img-full" id="imgFull">
                            <div class="comparator-slider" id="sliderBar"></div>
                        </div>
                    </div>
                </div>

                <div class="philosophie-sticky-content glass-box box-animee Animation styleDivSection"
                    id="GervoPartage">
                    <div class="philosophie-texte" style="width: 100%;">
                        <h3 style="margin: 0;">CREATION D'UNE APLICATION</h3>
                        <h1 style="margin-top : 3px;">Simplifier le partage des dossier sur un réseaux local.</h1>
                        <p>Cette application permet à une équipe de travailler facilement sur un dossier au sein
                            d'un même réseau local.</p>
                        <p>Mise en place en 3 étapes :</p>
                        <ul>
                            <li>Installer l'aplication</li>
                            <li>Choisisser un dossier</li>
                            <li>Donner le le lien d'accés</li>
                            <li>Et voilà, vous pouver travailler sur le dossier !</li>
                        </ul>
                        <button
                            onclick="window.open('https:\/\/gervo.fr/app/Installation_Beta_GervoTransfert_Local.exe', '_blank');"
                            style="max-width: 90px;" class="stylebtn"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-arrow-down-to-line preview-icon">
                                <path d="M12 17V3" />
                                <path d="m6 11 6 6 6-6" />
                                <path d="M19 21H5" />
                            </svg> Tester</button>
                    </div>
                    <div class="DemoGervoPartage">
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section style="flex-direction: column;" id="Contact">
            <div class="Seperation"></div>
            <div class="apropos-contenu">

                <div class="text titre-sticky-independant">
                    <div class="titre" id="Projet">
                        <h1>Contact</h1>
                    </div>
                </div>
                <div class="philosophie-sticky-content glass-box box-animee Animation styleDivSection"
                    id="ContactFormulaire" style="flex-direction: column;align-items: flex-start !important;">
                    <h1 style="margin-bottom: 35px;">Formulaire de contact :</h1>
                    <form action="/API/envoieMessage.php" method="POST" id="contact-form" class="contact-form">
                        <div class="form-group">
                            <input type="text" id="nom" name="nom" required autocomplete="name" placeholder="Nom">
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" required autocomplete="email"
                                placeholder="Adresse e-mail">
                        </div>
                        <div class="form-group">
                            <textarea id="message" name="message" rows="6" required
                                placeholder="Votre message..."></textarea>
                        </div>
                        <div style="display: none;" aria-hidden="true">
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        </div>
                        <input type="hidden" name="form_timestamp" value="1729688640">
                        <input type="hidden" name="bot_human_score" id="bot_human_score" value="0">
                        <input type="hidden" name="bot_behavior_data" id="bot_behavior_data" value="">

                        <button type="submit" class="stylebtn Clic-Particule">Envoyer le message</button>
                    </form>

                    <script src="/JS/anti-bot-behavior.js"></script>
                </div>

            </div>
        </section>
        <div class="modal">

        </div>
        <?php
        include 'footer.php';
        ?>
    </div>
    <script src="/JS/fond.js"></script>
    <script src="/JS/scroll.js"></script>
    <script src="/JS/modal.js"></script>
    <script src="/JS/anime.js"></script>
    <script src="/JS/detour.js"></script>
    <script src="JS/carousel.js"></script>
</body>

</html>