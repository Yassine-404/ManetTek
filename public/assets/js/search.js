// search.js

document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchInput');
    
    searchInput.addEventListener('input', function() {
        var searchTerm = searchInput.value.trim();
        
        if (searchTerm.length >= 2) {
            // Envoyer une requête AJAX au serveur
            searchTournaments(searchTerm);
        }
    });
});

function searchTournaments(searchTerm) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/search?tournament=' + searchTerm, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var tournaments = JSON.parse(xhr.responseText);
            // Mettre à jour l'affichage des tournois sur la page
            // (ex : remplacer le contenu de la liste des tournois avec les nouveaux résultats)
        }
    };
    xhr.send();
}
