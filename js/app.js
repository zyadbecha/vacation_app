document.addEventListener("DOMContentLoaded", function() {
    function loadOffers(query = "") {
        fetch(`api/search.php?query=${query}`)
            .then(response => response.json())
            .then(data => {
                const offersContainer = document.getElementById("offers-container");
                offersContainer.innerHTML = "";
                if (data.length === 0) {
                    offersContainer.innerHTML = "<div class='col-12'><p>Aucune offre trouvée.</p></div>";
                    return;
                }
                data.forEach(offer => {
                    const col = document.createElement("div");
                    col.className = "col-md-4";
                    col.innerHTML = `
                        <div class="card mb-4">
                            <img src="${offer.photos[0]}" class="card-img-top" alt="${offer.name}">
                            <div class="card-body">
                                <h5 class="card-title">${offer.name}</h5>
                                <p class="card-text">${offer.description.substring(0, 100)}...</p>
                                <p class="card-text"><strong>Prix : </strong>${offer.price} €</p>
                                <button class="btn btn-primary" onclick="reserveOffer('${offer._id}')">Réserver</button>
                            </div>
                        </div>
                    `;
                    offersContainer.appendChild(col);
                });
            })
            .catch(error => console.error("Erreur lors du chargement des offres :", error));
    }

    document.getElementById("searchForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const query = document.getElementById("searchInput").value;
        loadOffers(query);
    });

    loadOffers();
});

function reserveOffer(offerId) {
    const userId = localStorage.getItem("userId"); // Récupérer l'ID utilisateur depuis le stockage local

    if (!userId) {
        alert("Vous devez être connecté pour réserver.");
        return;
    }

    fetch("api/reservation.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ offerId, userId })
    })
    .then(response => response.json())
    .then(data => alert(data.message))
    .catch(error => console.error("Erreur :", error));
}
