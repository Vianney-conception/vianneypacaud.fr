const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
document.cookie = `modeSombre=${isDarkMode}; path=/; max-age=3600`; 


function changemodeClair(){
    const cookies = document.cookie.split('; ').reduce((acc, cookie) => {
        const [key, value] = cookie.split('=');
        acc[key] = value;
        return acc;
    }, {});
  if (cookies.modeSombre === 'true') {
        document.body.classList.add('Claire');
        document.cookie = `modeSombre=false; path=/; max-age=3600`;
        document.cookie = `ChoixMode=claire; path=/; max-age=3600`;
}
}

function changemodeSombre(){
    const cookies = document.cookie.split('; ').reduce((acc, cookie) => {
        const [key, value] = cookie.split('=');
        acc[key] = value;
        return acc;
    }, {});
  if (cookies.modeSombre === 'false') {
        document.body.classList.remove('Claire');
        document.cookie = `modeSombre=true; path=/; max-age=3600`;
        document.cookie = `ChoixMode=sombre; path=/; max-age=3600`;
}
}

function changemodeAuto(){
    const cookies = document.cookie.split('; ').reduce((acc, cookie) => {
        const [key, value] = cookie.split('=');
        acc[key] = value;
        return acc;
    }, {});
    document.body.classList.remove('Claire');
    document.cookie = `ChoixMode=auto; path=/; max-age=3600`;
    const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    document.cookie = `modeSombre=${isDarkMode}; path=/; max-age=3600`; 
    if (cookies.modeSombre === 'true') {
            document.body.classList.remove('Claire');
        } else {
            document.body.classList.add('sombre');
        }
}

setInterval(() => {
    const cookies = document.cookie.split('; ').reduce((acc, cookie) => {
        const [key, value] = cookie.split('=');
        acc[key] = value;
        return acc;
    }, {});
    if (cookies.ChoixMode === 'auto'){
        if (cookies.modeSombre === 'true') {
            document.body.classList.remove('Claire');
        } else {
            document.body.classList.add('sombre');
        }
    }else if(cookies.ChoixMode === 'sombre'){
        changemodeSombre();
    }
}, 100);


