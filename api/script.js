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

                //Variabile che apre il tag contenitore dove inserire tutti i record
                let html = '<ul>';

                //Per ogni prodotto, prende i campi della tabella
                //${ NOMETABELLA.NOMECAMPO }
                data.forEach(product => {
                    html += `<li>${product.nome} - € ${product.prezzo}</li>`;
                });

                //Variabile che chiude il tag contenitore
                html += '</ul>';

                productsList.innerHTML = html;
            })
            .catch(error => console.error('Errore:', error));
    }

    // Carica i prodotti all'avvio
    loadProducts();
});
