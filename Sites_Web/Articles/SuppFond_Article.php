<style>
article .DemoGervoDetourAPI {
    width: 100% !important;
    max-width: 500px !important;
    margin-top: 20px !important;
    display: flex !important;
    justify-content: center !important;
}

article .img-comparator {
    --ratio: 1;
    position: relative !important;
    display: none;
    width: min(100%, 400px, calc(70vh * var(--ratio))) !important;
    max-width: none !important;
    height: auto !important;
    aspect-ratio: var(--ratio) !important;
    overflow: hidden !important;
    border-radius: 12px !important;
    user-select: none;
    -webkit-user-select: none;
}

article .img-comparator.has-image {
    display: block !important;
}

article .img-comparator img {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    max-width: none !important;
    max-height: none !important;
    object-fit: fill !important;
    pointer-events: none !important;
}

article .img-comparator .img-cut {
    z-index: 1 !important;
}

article .img-comparator .img-full {
    z-index: 2 !important;
    clip-path: inset(0 50% 0 0) !important;
}
#SommaireArticle{
    display: none;
}
.comparator-slider {
    touch-action: none;
}
</style>
<div class="info banal">Vous vous apprêtez à tester une de nos API, avez-vous lu notre <a href="/Articles/GVD#repere2">politique de gestion des données ?</a></div>
<h1>Détourer vos images</h1>
<p>Cliquez sur <strong>Choisir une image</strong> puis sur <strong>Lancer le détourage</strong>. Une fois l'image détourée vous pouvez la télécharger en cliquant sur <strong>Télécharger le résultat</strong>.</p>
<div id="status-message" style="margin-bottom: 20px;"></div>
<div style="display: flex;gap: 20px;flex-direction: column;align-items: center;">
    <div>
        <input id="image-upload" type="file" accept="image/*" hidden>
        <button class="stylebtn" id="btn-upload" type="button">Choisir une image</button>
    </div>

    <div class="DemoGervoDetourAPI">
        <div class="img-comparator" id="comparator">
            <img src="" alt="" class="img-cut" id="imgCut">
            <img src="" alt="" class="img-full" id="imgFull">
            <div class="comparator-slider" id="sliderBar"></div>
        </div>
    </div>

    <div>
        <button class="stylebtn" id="btn-process" type="button">Lancer le détourage</button>
        <button class="stylebtn" id="btn-download" type="button" style="display: none;">Télécharger le résultat</button>
    </div>
</div>

<script>
const API_BASE = "https://detour.api.gervo.fr";
const imageUpload = document.getElementById("image-upload");
const btnUpload = document.getElementById("btn-upload");
const btnProcess = document.getElementById("btn-process");
const btnDownload = document.getElementById("btn-download");
const chargement = document.getElementById("Chargement");
const statusMessage = document.getElementById("status-message");
const comparator = document.getElementById("comparator");
const sliderBar = document.getElementById("sliderBar");
const imgCut = document.getElementById("imgCut");
const imgFull = document.getElementById("imgFull");
const article = document.querySelector("article");

let resultUrl = null;
let originalUrl = null;
let originalName = "image";
function setLoading(isLoading) {
    if (chargement) chargement.classList.toggle("cache", !isLoading);
    if (article) article.classList.toggle("flou", isLoading);
}
function setSliderPosition(percent) {
    percent = Math.max(0, Math.min(100, percent));
    sliderBar.style.left = percent + "%";
    imgFull.style.setProperty("clip-path", `inset(0 ${100 - percent}% 0 0)`, "important");
}

function moveSlider(clientX) {
    const rect = comparator.getBoundingClientRect();
    setSliderPosition(((clientX - rect.left) / rect.width) * 100);
}

let dragging = false;

sliderBar.addEventListener("pointerdown", (e) => {
    dragging = true;
    sliderBar.setPointerCapture(e.pointerId);
    e.preventDefault();
});

sliderBar.addEventListener("pointermove", (e) => {
    if (dragging) moveSlider(e.clientX);
});

const stopDrag = (e) => {
    dragging = false;
    if (sliderBar.hasPointerCapture(e.pointerId)) {
        sliderBar.releasePointerCapture(e.pointerId);
    }
};
sliderBar.addEventListener("pointerup", stopDrag);
sliderBar.addEventListener("pointercancel", stopDrag);
comparator.addEventListener("click", (e) => {
    if (e.target !== sliderBar) moveSlider(e.clientX);
});
btnUpload.addEventListener("click", () => {
    imageUpload.click();
});

imageUpload.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (!file) return;

    originalName = file.name.replace(/\.[^.]+$/, "");
    if (resultUrl) URL.revokeObjectURL(resultUrl);
    if (originalUrl) URL.revokeObjectURL(originalUrl);
    resultUrl = null;
    originalUrl = URL.createObjectURL(file);
    imgCut.removeAttribute("src");
    const probe = new Image();
    probe.onload = () => {
        comparator.style.setProperty("--ratio", probe.naturalWidth / probe.naturalHeight);
        imgFull.src = originalUrl;
        comparator.classList.add("has-image");
        setSliderPosition(50);
    };
    probe.src = originalUrl;
    statusMessage.innerHTML = "";
    btnDownload.style.display = "none";
    btnProcess.style.display = "";
});
btnProcess.addEventListener("click", async () => {
    const file = imageUpload.files[0];
    if (!file) {
        alert("Veuillez sélectionner une image.");
        return;
    }

    setLoading(true);
    statusMessage.innerHTML = "";

    const formData = new FormData();
    formData.append("file", file);
    formData.append("model", "u2net");

    try {
        const response = await fetch(`${API_BASE}/remove-bg`, {
            method: "POST",
            body: formData
        });

        if (!response.ok) {
            throw new Error("Erreur serveur");
        }

        const blob = await response.blob();
        if (resultUrl) URL.revokeObjectURL(resultUrl);
        resultUrl = URL.createObjectURL(blob);
        imgCut.src = resultUrl;
        btnProcess.style.display = "none";
        btnDownload.style.display = "";

        statusMessage.innerHTML = '<div class="info success">Votre image est détourée !</div>';
    } catch (error) {
        statusMessage.innerHTML = '<div class="info erreur">Quelque chose s\'est mal passé, veuillez réessayer.</div>';
        statusMessage.scrollIntoView({ behavior: "smooth", block: "center" });
    } finally {
        setLoading(false);
    }
});
btnDownload.addEventListener("click", () => {
    if (!resultUrl) return;
    const a = document.createElement("a");
    a.href = resultUrl;
    a.download = `${originalName}-detoure.png`;
    document.body.appendChild(a);
    a.click();
    a.remove();
});
</script>