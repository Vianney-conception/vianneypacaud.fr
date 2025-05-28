function getCookies() {
    return document.cookie.split('; ').reduce((acc, cookie) => {
        const [key, value] = cookie.split('=');
        acc[key] = value;
        return acc;
    }, {});
}

function setCookie(key, value, maxAge = 3600) {
    document.cookie = `${key}=${value}; path=/; max-age=${maxAge}`;
}

function updateButtonSelection(mode) {
    const modes = ['Claire', 'Auto', 'Sombre'];
    modes.forEach(m => {
        const btn = document.getElementById(`btn-Mode${m}`);
        if (btn) {
            btn.classList.toggle('modeChoisie', m.toLowerCase() === mode);
        }
    });
}

function applyTheme(mode) {
    const isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const body = document.body;

    if (mode === 'auto') {
        setCookie('modeSombre', isDarkMode);
        body.classList.toggle('Claire', !isDarkMode);
    } else if (mode === 'sombre') {
        body.classList.remove('Claire');
        setCookie('modeSombre', true);
    } else { // claire
        body.classList.add('Claire');
        setCookie('modeSombre', false);
    }
}

function changeMode(mode) {
    setCookie('ChoixMode', mode);
    updateButtonSelection(mode);
    applyTheme(mode);
}

document.getElementById('btn-ModeClaire')?.addEventListener('click', () => changeMode('claire'));
document.getElementById('btn-ModeSombre')?.addEventListener('click', () => changeMode('sombre'));
document.getElementById('btn-ModeAuto')?.addEventListener('click', () => changeMode('auto'));

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    const cookies = getCookies();
    if (cookies.ChoixMode === 'auto') {
        applyTheme('auto');
    }
});

(() => {
    const cookies = getCookies();
    const mode = cookies.ChoixMode || 'auto';
    updateButtonSelection(mode);
    applyTheme(mode);
})();