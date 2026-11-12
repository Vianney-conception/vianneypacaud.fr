<?php
/**
 * Moteur de recherche interne : index, score et rendu du formulaire.
 *
 * Source unique de vérité :
 *  - titres des pages     : $config (listeArticles.php)
 *  - descriptions         : $Resume (listeArticles.php)
 *  - sections / ancres    : les <h2 id="..."> de chaque X_Article.php (lus automatiquement)
 *  - texte des sections   : contenu des articles (recherche plein texte)
 *  - mots-clés éditoriaux : RECHERCHE_MOTS_CLES (synonymes, termes absents du texte)
 *
 * Ajouter un article = l'ajouter dans $config + créer X_Article.php.
 * Ajouter une section = écrire <h2 id="mon-repere">, elle devient un résultat /Articles/X#mon-repere.
 */

/** Mots ignorés (forme normalisée sans accents). */
const RECHERCHE_MOTS_VIDES = [
    'le', 'la', 'les', 'un', 'une', 'des', 'du', 'de', 'et', 'ou', 'au', 'aux', 'en', 'dans', 'par',
    'pour', 'sur', 'avec', 'sans', 'ce', 'ces', 'cet', 'cette', 'se', 'sa', 'son', 'ses', 'leur', 'leurs',
    'qui', 'que', 'quoi', 'dont', 'est', 'sont', 'il', 'elle', 'ils', 'elles', 'nous', 'vous', 'je', 'tu',
    'on', 'ne', 'pas', 'vos', 'votre', 'nos', 'notre', 'mes', 'mon', 'ma', 'tout', 'tous', 'toute', 'toutes',
];

/** Translittération des caractères accentués. */
const RECHERCHE_ACCENTS = [
    'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'ç' => 'c',
    'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
    'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ù' => 'u', 'ú' => 'u',
    'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ÿ' => 'y', 'œ' => 'oe', 'æ' => 'ae',
    'À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ã' => 'a', 'Ä' => 'a', 'Å' => 'a', 'Ç' => 'c',
    'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i',
    'Ñ' => 'n', 'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Õ' => 'o', 'Ö' => 'o', 'Ù' => 'u', 'Ú' => 'u',
    'Û' => 'u', 'Ü' => 'u', 'Ý' => 'y', 'Œ' => 'oe', 'Æ' => 'ae',
];

/** Recherches proposées quand le champ est vide ou sans résultat. */
const RECHERCHE_SUGGESTIONS = ['CGV', 'RGPD', 'Détourage', 'Paiement', 'Contact'];

/** Nombre maximum de résultats affichés sans JavaScript. */
const RECHERCHE_LIMITE_SERVEUR = 20;

/** Entrées hors articles : sections de l'accueil et outils externes. */
const RECHERCHE_PAGES_FIXES = [
    ['titre' => 'Accueil', 'url' => '/', 'contexte' => 'Page d\'accueil du site', 'type' => 'page',
        'motsCles' => ['accueil', 'home', 'index', 'vianney', 'pacaud', 'developpeur', 'web']],
    ['titre' => 'À propos', 'url' => '/#A_proposRepere', 'contexte' => 'Accueil', 'type' => 'section',
        'motsCles' => ['propos', 'en savoir plus', 'presentation', 'parcours']],
    ['titre' => 'Formulaire de contact', 'url' => '/#Contact', 'contexte' => 'Accueil', 'type' => 'section',
        'motsCles' => ['contact', 'contacter', 'formulaire', 'e-mail', 'mail', 'message', 'numero', 'tel', 'telephone']],
    ['titre' => 'Projets', 'url' => '/#Projet', 'contexte' => 'Accueil', 'type' => 'section',
        'motsCles' => ['projet', 'projets', 'ide', 'exemple', 'realisations', 'portfolio']],
    ['titre' => 'Gervo Outils', 'url' => 'https://outils.gervo.fr', 'contexte' => 'Site externe · outils.gervo.fr', 'type' => 'externe',
        'motsCles' => ['outils', 'utilitaires', 'apps', 'gervo']],
    ['titre' => 'Chiffrement', 'url' => 'https://chiffrement.gervo.fr', 'contexte' => 'Site externe · chiffrement.gervo.fr', 'type' => 'externe',
        'motsCles' => ['chiffrement', 'crypto', 'securite', 'aes', 'chiffrer']],
    ['titre' => 'Générateur de QR Code', 'url' => 'https://qr-code.gervo.fr', 'contexte' => 'Site externe · qr-code.gervo.fr', 'type' => 'externe',
        'motsCles' => ['qr', 'code', 'qr-code', 'qrcode', 'generateur']],
];

/**
 * Mots-clés éditoriaux : clé "ARTICLE" pour la page, "ARTICLE#id-du-h2" pour une section.
 * Une clé dont le <h2 id> n'existe plus est ignorée : aucun lien mort possible.
 */
const RECHERCHE_MOTS_CLES = [
    'CGV' => ['CGV', 'conditions', 'generales', 'vente', 'prestataire', 'Vianney Pacaud', 'entrepreneur',
        'auto-entreprise', 'services', 'commande', 'devis', 'tarifs', 'prix', 'facture', 'paiement'],
    'CGV#designation-prestataire' => ['prestataire', 'Vianney Pacaud', 'entrepreneur', 'individuel',
        'auto-entreprise', 'SIREN', 'SIRET', '989574538', '98957453800017', 'Clisson', 'contact', 'email', 'adresse', 'siege'],
    'CGV#champ-application' => ['champ', 'application', 'prestations', 'services', 'numeriques', 'web', 'site',
        'HTML', 'CSS', 'JS', 'PHP', 'Go', 'Python', 'visuels'],
    'CGV#commandes-devis' => ['commandes', 'devis', 'acompte', 'validite', 'litige', 'annulation', 'refus'],
    'CGV#tarifs' => ['tarifs', 'prix', 'facture', 'ferme', 'non revisable', 'montant', 'cout'],
    'CGV#conditions-paiement' => ['paiement', 'modalites', 'acompte', 'solde', 'comptant', 'encaissement', 'reglement'],
    'CGV#retard-paiement' => ['retard', 'penalites', 'taux', 'suspension', 'interruption', 'desactivation',
        'suppression', 'impaye'],
    'CGV#propriete-intellectuelle' => ['propriete', 'intellectuelle', 'droits', 'auteur', 'code', 'source',
        'reproduction', 'revente', 'licence'],
    'CGV#fourniture-services' => ['fourniture', 'delais', 'obligation', 'moyens', 'reception', 'reserves', 'livraison'],
    'CGV#garanties-responsabilite' => ['garanties', 'responsabilite', 'conformite', 'vices', 'caches', 'force', 'majeure'],
    'CGV#donnees-personnelles' => ['donnees', 'personnelles', 'RGPD', 'acces', 'rectification', 'effacement', 'opposition'],
    'CGV#droit-applicable' => ['droit', 'applicable', 'litiges', 'tribunaux', 'francais', 'amiable', 'juridiction'],

    'ML' => ['ML', 'mentions', 'legales', 'editeur', 'Vianney Pacaud', 'hebergeur', 'o2switch', 'LCEN',
        'directeur', 'publication'],
    'ML#informations-generales' => ['LCEN', 'confiance', 'economie', 'numerique', 'loi', 'legales'],
    'ML#informations-editeur' => ['editeur', 'Vianney Pacaud', 'entrepreneur', 'Clisson', 'SIRET', 'SIREN',
        '989574538', '98957453800017', 'email', 'directeur', 'publication'],
    'ML#informations-hebergeur' => ['hebergeur', 'hebergement', 'o2switch', 'Clermont-Ferrand', 'SIRET',
        '51090980700032', 'support', 'telephone'],
    'ML#propriete-intellectuelle' => ['propriete', 'intellectuelle', 'exclusive', 'code', 'source', 'logos',
        'reproduction', 'interdite', 'copyright'],
    'ML#donnees-personnelles' => ['protection', 'donnees', 'personnelles', 'RGPD', 'acces', 'rectification',
        'effacement', 'opposition'],

    'GVD' => ['gestion', 'donnees', 'personnelles', 'vie', 'privee', 'RGPD', 'confidentialite', 'cookies',
        'politique', 'API', 'RAM'],
    'GVD#donnees-visite' => ['donnees', 'visite', 'IP', 'port', 'HTTP', 'referrer', 'Accept-Language',
        'User-Agent', 'navigateur', 'OS', 'systeme', 'resolution', 'ecran', 'viewport', 'fenetre', 'langue',
        'fuseau', 'processeur', 'threads', 'RAM', 'memoire'],
    'GVD#donnees-api' => ['API', 'detourage', 'image', 'RAM', 'ephemere', 'memoire', 'vive', 'stockage',
        'disque', 'detruite', 'suppression', 'appels'],
    'GVD#donnees-prestations' => ['prestations', 'commandes', 'facturation', 'cgv'],
    'GVD#droits-rgpd' => ['RGPD', 'droits', 'acces', 'rectification', 'effacement', 'oubli', 'limitation',
        'portabilite', 'opposition', 'formulaire', 'contact'],

    'SuppFond' => ['API', 'detourage', 'detourer', 'image', 'photo', 'fond', 'arriere-plan', 'retirer',
        'enlever', 'supprimer', 'effacer', 'transparent', 'png', 'u2net', 'gratuit'],
];

require_once __DIR__ . '/listeArticles.php';

/** Minuscules, sans accents ni ponctuation. Doit rester identique à normaliser() dans /JS/search.js. */
function rechercheNormaliser(string $texte): string
{
    $texte = strtolower(strtr($texte, RECHERCHE_ACCENTS));
    return trim((string) preg_replace('/[^a-z0-9]+/', ' ', $texte));
}

/** Mots uniques et significatifs (≥ 2 caractères, hors mots vides). */
function rechercheMots(string $texte): array
{
    $normalise = rechercheNormaliser($texte);
    if ($normalise === '') {
        return [];
    }
    $mots = array_filter(explode(' ', $normalise), function ($mot) {
        return strlen($mot) >= 2 && !in_array($mot, RECHERCHE_MOTS_VIDES, true);
    });
    return array_values(array_unique($mots));
}

/** Termes d'une requête (les mots vides ne sont retirés que s'il reste autre chose). Miroir de termes() en JS. */
function rechercheTermes(string $requete): array
{
    $normalise = rechercheNormaliser($requete);
    if ($normalise === '') {
        return [];
    }
    $tous = array_values(array_unique(array_filter(explode(' ', $normalise), function ($t) {
        return strlen($t) >= 2;
    })));
    $utiles = array_values(array_diff($tous, RECHERCHE_MOTS_VIDES));
    return array_slice($utiles ?: $tous, 0, 8);
}

/** Texte lisible d'un fragment de source (code PHP, scripts, styles et balises retirés). */
function rechercheTexteBrut(string $html): string
{
    $html = (string) preg_replace(['#<\?(?:php|=).*?(?:\?>|\z)#si', '#<(script|style)\b[^>]*>.*?</\1>#si'], ' ', $html);
    $html = (string) preg_replace('#<[^>]+>#', ' ', $html);
    return html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/** Titre affichable d'un <h2>. */
function rechercheTitre(string $h2): string
{
    return rtrim(trim((string) preg_replace('/\s+/u', ' ', rechercheTexteBrut($h2))), ' :');
}

/** Entrée d'index compacte (mots-clés et texte déjà normalisés, séparés par des espaces). */
function rechercheEntree(string $titre, string $url, string $contexte, string $type, array $motsCles, string $html = ''): array
{
    $cles = rechercheMots(implode(' ', $motsCles));
    $texte = $html === '' ? [] : array_values(array_diff(rechercheMots(rechercheTexteBrut($html)), $cles));
    return [
        'titre' => $titre,
        'url' => $url,
        'contexte' => $contexte,
        'type' => $type,
        'motsCles' => implode(' ', $cles),
        'texte' => implode(' ', $texte),
    ];
}

/** Index complet du site, construit à partir des articles (une seule fois par requête HTTP). */
function rechercheIndex(): array
{
    static $index = null;
    if ($index !== null) {
        return $index;
    }
    $config = $GLOBALS['config'] ?? [];
    $resume = $GLOBALS['Resume'] ?? [];
    $index = [];

    foreach (RECHERCHE_PAGES_FIXES as $p) {
        $index[] = rechercheEntree($p['titre'], $p['url'], $p['contexte'], $p['type'], $p['motsCles']);
    }

    foreach ($config as $cle => $titrePage) {
        $fichier = __DIR__ . '/' . $cle . '_Article.php';
        if ($cle === 'Recherche' || !preg_match('/^[A-Za-z0-9]+$/', $cle) || !is_file($fichier)) {
            continue;
        }
        $source = (string) file_get_contents($fichier);
        $morceaux = preg_split('#(<h2\b[^>]*>.*?</h2>)#si', $source, -1, PREG_SPLIT_DELIM_CAPTURE) ?: [$source];

        $htmlPage = $morceaux[0];
        $sections = [];
        for ($i = 1, $n = count($morceaux); $i < $n; $i += 2) {
            $h2 = $morceaux[$i];
            $contenu = $morceaux[$i + 1] ?? '';
            if (preg_match('#^<h2\b[^>]*\bid\s*=\s*["\']([A-Za-z0-9_-]+)["\']#i', $h2, $m)) {
                $sections[] = [$m[1], rechercheTitre($h2), $contenu];
            } else {
                $htmlPage .= ' ' . $h2 . ' ' . $contenu; // <h2> sans repère : rattaché à la page
            }
        }

        $index[] = rechercheEntree($titrePage, '/Articles/' . $cle, $resume[$cle] ?? '', 'page',
            RECHERCHE_MOTS_CLES[$cle] ?? [], $htmlPage);
        foreach ($sections as [$id, $titreSection, $contenu]) {
            $index[] = rechercheEntree($titreSection, '/Articles/' . $cle . '#' . $id, $titrePage, 'section',
                RECHERCHE_MOTS_CLES[$cle . '#' . $id] ?? [], $titreSection . ' ' . $contenu);
        }
    }
    return $index;
}

/** Vrai si les deux mots sont à une distance d'édition ≤ 1 (substitution, insertion ou suppression). */
function rechercheProche(string $a, string $b): bool
{
    $la = strlen($a);
    $lb = strlen($b);
    if (abs($la - $lb) > 1) {
        return false;
    }
    if ($la === $lb) {
        $diff = 0;
        for ($i = 0; $i < $la; $i++) {
            if ($a[$i] !== $b[$i] && ++$diff > 1) {
                return false;
            }
        }
        return true;
    }
    if ($la > $lb) {
        [$a, $b, $la, $lb] = [$b, $a, $lb, $la];
    }
    $i = 0;
    $j = 0;
    $saut = false;
    while ($i < $la && $j < $lb) {
        if ($a[$i] === $b[$j]) {
            $i++;
            $j++;
        } elseif ($saut) {
            return false;
        } else {
            $saut = true;
            $j++;
        }
    }
    return true;
}

/** Meilleur score d'un terme dans une liste de mots : exact > préfixe > faute de frappe. */
function rechercheScoreMots(array $mots, string $terme, float $poids): float
{
    $longueur = strlen($terme);
    $meilleur = 0.0;
    foreach ($mots as $mot) {
        if ($mot === $terme) {
            return $poids;
        }
        if (strncmp($mot, $terme, $longueur) === 0) {
            $meilleur = max($meilleur, $poids * 0.75);
        } elseif ($meilleur === 0.0 && $longueur >= 5 && rechercheProche($mot, $terme)) {
            $meilleur = $poids * 0.4;
        }
    }
    return $meilleur;
}

/** Score d'une entrée (0 si un terme est absent : logique ET). Miroir de scorer() dans /JS/search.js. */
function rechercheScore(array $entree, array $termes): float
{
    $titre = explode(' ', rechercheNormaliser($entree['titre']));
    $cles = $entree['motsCles'] === '' ? [] : explode(' ', $entree['motsCles']);
    $texte = $entree['texte'] === '' ? [] : explode(' ', $entree['texte']);
    $total = 0.0;
    foreach ($termes as $terme) {
        $score = max(
            rechercheScoreMots($titre, $terme, 12),
            rechercheScoreMots($cles, $terme, 8),
            rechercheScoreMots($texte, $terme, 4)
        );
        if ($score === 0.0) {
            return 0.0;
        }
        $total += $score;
    }
    if ($entree['type'] === 'page') {
        $total += 1;
    } elseif ($entree['type'] === 'externe') {
        $total -= 0.5;
    }
    return $total;
}

/** Résultats triés par pertinence (utilisé pour le rendu sans JavaScript). */
function rechercheExecuter(string $requete): array
{
    $termes = rechercheTermes($requete);
    if (!$termes) {
        return [];
    }
    $resultats = [];
    foreach (rechercheIndex() as $position => $entree) {
        $score = rechercheScore($entree, $termes);
        if ($score > 0) {
            $resultats[] = ['score' => $score, 'position' => $position] + $entree;
        }
    }
    usort($resultats, function ($a, $b) {
        return [$b['score'], $a['position']] <=> [$a['score'], $b['position']];
    });
    return $resultats;
}

/** Index + mots vides en JSON, injectable dans <script type="application/json"> (aucun "</script>" possible). */
function rechercheIndexJson(): string
{
    $json = json_encode(['motsVides' => RECHERCHE_MOTS_VIDES, 'entrees' => rechercheIndex()],
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_INVALID_UTF8_SUBSTITUTE);
    return $json === false ? '{"motsVides":[],"entrees":[]}' : $json;
}

/** Requête issue de ?q= (bornée, nettoyée). */
function rechercheRequete(): string
{
    $q = isset($_GET['q']) && is_string($_GET['q']) ? $_GET['q'] : '';
    $q = trim((string) preg_replace('/\s+/u', ' ', $q));
    return function_exists('mb_substr') ? mb_substr($q, 0, 100, 'UTF-8') : substr($q, 0, 100);
}

/** Transforme un segment d'URL inconnu ("conditions-vente.php") en requête de recherche pour la 404. */
function rechercheDepuisChemin(string $segment): string
{
    $segment = rawurldecode($segment);
    $segment = (string) preg_replace('/\.(php|html?)$/i', '', $segment);
    $segment = trim((string) preg_replace('/[-_.+]+/', ' ', $segment));
    return preg_match('/^[\p{L}\p{N} ]{3,40}$/u', $segment) ? $segment : '';
}

function rechercheEchapper(string $texte): string
{
    return htmlspecialchars($texte, ENT_QUOTES, 'UTF-8');
}

/** Liens de recherches suggérées. */
function rechercheSuggestionsHtml(string $intro): string
{
    $liens = [];
    foreach (RECHERCHE_SUGGESTIONS as $suggestion) {
        $liens[] = '<li><a href="/Articles/Recherche?q=' . rawurlencode($suggestion) . '" data-suggestion="'
            . rechercheEchapper($suggestion) . '">' . rechercheEchapper($suggestion) . '</a></li>';
    }
    return '<div class="suggestionsRecherche"><span>' . rechercheEchapper($intro) . '</span><ul>'
        . implode('', $liens) . '</ul></div>';
}

/**
 * Affiche le composant de recherche complet.
 *
 * @param string $requete         Valeur initiale du champ.
 * @param bool   $resultatsServeur Afficher la liste de résultats calculée en PHP (page /Articles/Recherche?q=...).
 */
function rechercheFormulaire(string $requete = '', bool $resultatsServeur = false): void
{
    $resultats = ($resultatsServeur && $requete !== '') ? rechercheExecuter($requete) : [];
    ?>
<form id="ZonedeRecherche" role="search" action="/Articles/Recherche" method="get" autocomplete="off" novalidate>
    <div class="ZonedeRechercheContenant">
        <label for="champRecherche" class="sr-only">Rechercher sur ce site</label>
        <div class="ZonedeRechercheChamp">
            <input id="champRecherche" name="q" type="search" maxlength="100"
                placeholder="Rechercher sur ce site..." value="<?= rechercheEchapper($requete) ?>"
                role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="listeSuggestions"
                aria-describedby="etatRecherche" enterkeyhint="search" spellcheck="false">
            <button type="submit" class="boutonRecherche" aria-label="Lancer la recherche">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.3-4.3" /></svg>
            </button>
        </div>
        <div class="ZonedeProposition" hidden>
            <ul id="listeSuggestions" role="listbox" aria-label="Suggestions de recherche"></ul>
        </div>
        <p id="etatRecherche" class="etatRecherche" role="status" aria-live="polite"></p>
        <?= rechercheSuggestionsHtml('Recherches fréquentes :') ?>
    </div>
</form>
<?php if ($resultatsServeur && $requete !== ''): ?>
<section class="resultatsRecherche" aria-labelledby="titreResultats">
    <?php if (!$resultats): ?>
        <h2 id="titreResultats">Aucun résultat pour « <?= rechercheEchapper($requete) ?> »</h2>
        <p>Vérifiez l'orthographe ou essayez un terme plus général.</p>
    <?php else: ?>
        <h2 id="titreResultats"><?= count($resultats) ?> résultat<?= count($resultats) > 1 ? 's' : '' ?>
            pour « <?= rechercheEchapper($requete) ?> »</h2>
        <ul>
            <?php foreach (array_slice($resultats, 0, RECHERCHE_LIMITE_SERVEUR) as $r): ?>
                <li>
                    <a href="<?= rechercheEchapper($r['url']) ?>"<?= $r['type'] === 'externe' ? ' rel="noopener"' : '' ?>>
                        <?= rechercheEchapper($r['titre']) ?></a>
                    <?php if ($r['contexte'] !== ''): ?>
                        <small><?= rechercheEchapper($r['contexte']) ?></small>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if (count($resultats) > RECHERCHE_LIMITE_SERVEUR): ?>
            <p>Seuls les <?= RECHERCHE_LIMITE_SERVEUR ?> résultats les plus pertinents sont affichés : précisez votre recherche.</p>
        <?php endif; ?>
    <?php endif; ?>
</section>
<?php endif; ?>
<script type="application/json" id="indexRecherche"><?= rechercheIndexJson() ?></script>
<script src="/JS/search.js" defer></script>
<?php
}
