const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
document.cookie = `modeSombre=${isDarkMode}; path=/; max-age=3600`; 

setInterval(() => {
    const cookies = document.cookie.split('; ').reduce((acc, cookie) => {
        const [key, value] = cookie.split('=');
        acc[key] = value;
        return acc;
    }, {});

    if (cookies.modeSombre === 'true') {
        document.body.classList.remove('Claire');
    } else {
        document.body.classList.add('Claire');
    }
}, 100);