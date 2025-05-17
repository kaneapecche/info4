// Fonction pour créer un cookie
function definirCookie(nom, valeur, jours) {
    const date = new Date();
    date.setTime(date.getTime() + (jours * 24 * 60 * 60 * 1000));
    document.cookie = `${nom}=${valeur};expires=${date.toUTCString()};path=/`;
}

// Fonction pour lire un cookie
function lireCookie(nom) {
    const cookies = document.cookie.split(';');
    for (let cookie of cookies) {
        let [cle, valeur] = cookie.trim().split('=');
        if (cle === nom) return valeur;
    }
    return null;
}

// Appliquer le thème au chargement de la page en fonction du cookie
window.addEventListener('DOMContentLoaded', () => {
    const fichierCSS = document.getElementById('theme-css'); // Lien vers la feuille de style
    const selecteurTheme = document.getElementById('theme-switcher'); // Menu déroulant de choix
    const themeChoisi = lireCookie('theme'); // Lire le thème dans le cookie

    // Liste des feuilles de style valides
    const themesValides = ['projet.css/style-default.css', 'projet.css/style-dark.css', 'projet.css/style-accessible.css'];

    // Si un thème valide est trouvé dans le cookie, on l'applique
    if (themeChoisi && themesValides.includes(themeChoisi)) {
        fichierCSS.href = themeChoisi;
        selecteurTheme.value = themeChoisi;
    } else {
        fichierCSS.href = 'projet.css/style-default.css'; // Sinon, on applique le thème par défaut
    }

    // Quand l'utilisateur change le thème via le menu déroulant
    selecteurTheme.addEventListener('change', () => {
        const themeSelectionne = selecteurTheme.value;
        if (themesValides.includes(themeSelectionne)) {
            fichierCSS.href = themeSelectionne; // Appliquer le thème sélectionné
            definirCookie('theme', themeSelectionne, 30); // Sauvegarder le choix dans un cookie
        }
    });
});
