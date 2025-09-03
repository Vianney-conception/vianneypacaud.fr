function detectRenderingEngine() {
    const ua = navigator.userAgent;
  
    if (ua.includes("Gecko/") && !ua.includes("like Gecko")) {
      console.log("Moteur de rendu : Gecko (utilisé par Firefox)");
    } else if (ua.includes("AppleWebKit/") && ua.includes("Chrome") && ua.includes("Safari")) {
      console.log("Moteur de rendu : Blink (utilisé par Chrome, Edge, Opera)");
    } else if (ua.includes("AppleWebKit/") && !ua.includes("Chrome")) {
      console.log("Moteur de rendu : WebKit (utilisé par Safari)");
    } else if (ua.includes("Trident/") || ua.includes("MSIE")) {
      console.log("Moteur de rendu : Trident (utilisé par Internet Explorer)");
    } else {
      console.log("Moteur de rendu inconnu");
    }
  }
  
  detectRenderingEngine();
  
  function detectAndApplyGeckoClass() {
    const ua = navigator.userAgent;
    if (ua.includes("Gecko/") && !ua.includes("like Gecko")) {
      document.body.classList.add("Gecko");
      console.log("Moteur de rendu : Gecko — classe 'Gecko' ajoutée à <body>");
    }
  }
  
  window.addEventListener("DOMContentLoaded", detectAndApplyGeckoClass);
  
  