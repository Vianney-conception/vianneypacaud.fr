<?php
session_start();
require_once '../../itnCom/clee/config.php';

if (isset($_SESSION['user'])) {
  echo ('<div class="Info"><p>Vous ête dejà Connecté  <a href="/API/Deconexion/">Deconexion</a></p></div>');
  die();
}
?>


<div class="Info cache">
  <p></p>
</div>

<div class="container-login">
  <img src="/itnCom/logo/VioletGrandSVG.svg" alt="Logo" class="logo">
  <h2>Veuillez vous connecter</h2>
  <form id="loginForm" action="../../itnCom/clee/Connexion.php" method="post">
    <div class="form-group">
      <input placeholder="E-mail" type="email" name="email" id="nom" required>
    </div>
    <div class="form-group">
      <div class="password-container">
        <input placeholder="Mot de passe" id="motDePasse" type="password" name="password" required>
        <svg class="password-toggle" id="togglePassword" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#3B1351">
          <path d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z" />
        </svg>
      </div>
    </div>
    <button id="Connexion" type="submit" class="btn">Connexion</button>
    <button type="button" class="btn" onclick="callNewCompte()">Créer un compte</button>
    <script>
      function callNewCompte() {
        try {
          if (typeof window.parent.NewCompte === "function") {
            window.parent.NewCompte();
          } else {
            console.warn("La fonction 'NewCompte' n'existe pas dans le parent.");
          }
        } catch (e) {
          console.error("Erreur lors de l’appel de 'NewCompte' dans le parent :", e);
        }
      }
    </script>
  </form>
</div>

<script>
  const passwordInput = document.getElementById('motDePasse');
  const toggleIcon = document.getElementById('togglePassword');
  const iconPath = toggleIcon.querySelector('path');


  const visibleIcon = "M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z";

  const hiddenIcon = "m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Z";


  toggleIcon.addEventListener('click', () => {
    const visible = toggleIcon.getAttribute('data-visible') === 'true';
    passwordInput.type = visible ? 'password' : 'text';
    iconPath.setAttribute('d', visible ? hiddenIcon : visibleIcon);
    toggleIcon.setAttribute('data-visible', !visible);
  });


  passwordInput.addEventListener('focus', () => {
    toggleIcon.style.fill = '#E46A26';
  });

  passwordInput.addEventListener('blur', () => {
    toggleIcon.style.fill = '#3B1351';
  });

  passwordInput.addEventListener('mouseover', () => {
    toggleIcon.style.fill = '#E46A26';
  });

  passwordInput.addEventListener('mouseout', () => {
    if (!passwordInput.matches(':focus')) {
      toggleIcon.style.fill = '#3B1351';
    }
  });
</script>

<script>
  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
  }

  const code = getCookie('EtatConnexion');
  const infoDiv = document.querySelector('.Info');
  const infoText = infoDiv.querySelector('p');

  const messages = {
    1: "Mot de passe incorrect.",
    2: "Adresse email invalide.",
    3: "Utilisateur non trouvé.",
    4: "Veuillez remplir tous les champs.",
    5: "Connexion réussie !"
  };

  if (code && messages[code]) {
    infoText.textContent = messages[code];
    infoDiv.classList.remove('cache');

    if (code !== "5") {
      document.cookie = "EtatConnexion=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }
  }
</script>