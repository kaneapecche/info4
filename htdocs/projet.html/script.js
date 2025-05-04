function chargerVoyages() {
    fetch('voyages.json')
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById('listeVoyages');
        for (let id in data) {
          const voyage = data[id];
  
          const div = document.createElement('div');
          div.className = 'voyage';
          div.innerHTML = `
            <h3>${voyage.titre}</h3>
            <p>${voyage.description}</p>
            <p><strong>Prix :</strong> ${voyage.prix} €</p>
            <button onclick="ajouterAuPanier(${id})">Ajouter au panier</button>
          `;
          container.appendChild(div);
        }
      });
  }
  
  function ajouterAuPanier(voyageId) {
    fetch('ajouter_panier.php', {
      method: 'POST',
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: 'voyageId=' + voyageId
    })
    .then(response => response.text())
    .then(() => voirPanier());
  }
  
  function supprimerDuPanier(voyageId) {
    fetch('supprimer_panier.php', {
      method: 'POST',
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: 'voyageId=' + voyageId
    })
    .then(response => response.text())
    .then(() => voirPanier());
  }
  
  function viderPanier() {
    fetch('vider_panier.php')
      .then(response => response.text())
      .then(() => voirPanier());
  }
  
  function voirPanier() {
    fetch('voir_panier.php')
      .then(response => response.text())
      .then(data => {
        document.getElementById('monPanier').innerHTML = data;
      });
  }
  
  window.onload = chargerVoyages;
  
