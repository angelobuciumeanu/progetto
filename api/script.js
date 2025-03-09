document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('productForm');
    const productsList = document.getElementById('productsList');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch('api/addProduct.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                form.reset();
                loadProducts();
            }
        })
        .catch(error => console.error('Errore:', error));
    });

    function loadProducts() {
        fetch('api/getProduct.php')
            .then(response => response.json())
            .then(data => {
                productsList.innerHTML = ''; // Pulisce la lista prima di caricare i prodotti

                data.forEach(product => {
                    // Creazione della card per ogni prodotto
                    let card = document.createElement("div");
                    card.classList.add("product-card");

                    card.innerHTML = `
                        <h3>${product.nome}</h3>
                        <p>Prezzo: €${parseFloat(product.prezzo).toFixed(2)}</p>
                        <p>Categoria: ${product.categoria}</p>
                    `;

                    productsList.appendChild(card);
                });
            })
            .catch(error => console.error('Errore:', error));
    }

    // Carica i prodotti all'avvio
    loadProducts();
});
