import itertools
import string
import time
import whois

# ==================== CONFIGURATION ====================
EXTENSION = "fr"  # L'extension à tester (ex: fr, eu, com, in)

# Liste d'exclusion : ajoutez ici les domaines exacts ou les mots que vous ne voulez pas tester
LISTE_EXCLUSION = [
    "v1.fr",
    "ab.fr",
    "ov.fr",
    "bk.fr",
    # Vous pouvez aussi ajouter des mots clés à exclure si vous le souhaitez
]

# Définition des caractères à tester (Lettres minuscules + Chiffres)
CARACTERES = string.ascii_lowercase + string.digits
# =======================================================


def domaine_est_exclu(domaine, liste_exclusion):
    """Vérifie si le domaine est dans la liste d'exclusion."""
    return domaine.lower() in [d.lower() for d in liste_exclusion]


def verifier_disponibilite(domaine):
    """Interroge le WHOIS pour savoir si le domaine est disponible.

    Retourne True si disponible, False si pris, None si erreur.
    """
    try:
        w = whois.whois(domaine)
        # Si le WHOIS ne renvoie aucune date de création ou d'expiration,
        # ou si le texte indique que le domaine n'est pas trouvé, il est probablement libre.
        if not w.domain_name:
            return True
        return False
    except whois.parser.PyWhoisError:
        # La plupart des serveurs WHOIS lèvent cette erreur si le domaine n'existe pas (donc libre !)
        return True
    except Exception as e:
        print(f"⚠️ Erreur de connexion pour {domaine}: {e}")
        return None


def generer_et_tester():
    print(
        f"🔎 Démarrage de la recherche des domaines de 3 caractères .{EXTENSION}..."
    )
    print(f"🚫 {len(LISTE_EXCLUSION)} domaines sont exclus de la recherche.\n")

    # Génère toutes les combinaisons possibles de 3 caractères (ex: aaa, aab... zzz... 999)
    combinaisons = itertools.product(CARACTERES, repeat=2)

    domaines_trouves = []

    for comb in combinaisons:
        nom_base = "".join(comb)
        domaine = f"{nom_base}.{EXTENSION}"

        # 1. Vérification de la liste d'exclusion
        if domaine_est_exclu(domaine, LISTE_EXCLUSION):
            print(f"⏭️ {domaine} ignoré (présent dans la liste d'exclusion)")
            continue

        print(f"Vérification de {domaine}...", end="\r")

        # 2. Interrogation du serveur WHOIS
        disponible = verifier_disponibilite(domaine)

        if disponible:
            print(f"✅ DISPONIBLE : {domaine}                       ")
            domaines_trouves.append(domaine)
            # Sauvegarde immédiate dans un fichier texte pour ne rien perdre
            with open("domaines_libres.txt", "a") as f:
                f.write(domaine + "\n")

        # 3. Pause de sécurité pour éviter de se faire bannir son IP par le serveur WHOIS
        # 0.5 seconde est un bon compromis, vous pouvez l'augmenter si le serveur bloque
        time.sleep(0.5)

    print("\n================ RECHERCHE TERMINÉE ================")
    print(f"🎉 {len(domaines_trouves)} domaines disponibles trouvés !")
    print("Ils ont été sauvegardés dans le fichier 'domaines_libres.txt'.")


if __name__ == "__main__":
    generer_et_tester()