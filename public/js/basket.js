document.addEventListener("DOMContentLoaded", function(event) {
    document.getElementById('basket-products-quantity').innerHTML = localStorage.getItem('totalQuantity');
});

function openBasket() {
    let storedProducts = JSON.parse(localStorage.getItem("products"));

    if (storedProducts === null || storedProducts.length === 0) {
        document.getElementById('basket-total-price').innerHTML = 0;
        document.getElementById('basket-content').innerHTML = 'Panier vide';
        $('#cartModal').modal('show');

        return;
    }

    $.ajax({
        url: '/basket',
        data: { products: storedProducts },
        type: 'POST'
    }).done(function(data) {
        let qty = 1;
        let total = 0;
        let productList = '';

        data.forEach((product) => {
            qty = localStorage.getItem('product' + product.id);
            total += product.price * qty;
            productList += `
                <tr>
                    <td>${product.name}</td>
                    <td>${product.price} €</td>
                    <td class="qty">
                        <input type="hidden" name="product[]" value="${product.id}">
                        <input type="number" name="quantity[]" class="form-control" id="input-product-${product.id}" value="${qty}">
                    </td>
                    <td>${product.price * qty} €</td>
                </tr>
            `;
        });

        document.getElementById('basket-total-price').innerHTML = total;
        document.getElementById('basket-content').innerHTML = productList;
        $('#cartModal').modal('show');
    });
}

function clearBasket() {
    localStorage.clear();
}
