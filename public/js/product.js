
function addProductToBasket(id) {
    storeProduct(id);
    let productQuantity = localStorage.getItem('product' + id);
    if (productQuantity === null) {
        productQuantity = 0;
    }

    localStorage.setItem('product' + id, parseInt(productQuantity) + 1);

    let totalQuantity = localStorage.getItem('totalQuantity');

    totalQuantity = (totalQuantity === null) ? 1 : parseInt(totalQuantity) + 1;
    localStorage.setItem('totalQuantity', totalQuantity);

    document.getElementById('basket-products-quantity').innerHTML = totalQuantity;
}

function retireProductToBasket(id) {
    let productQuantity = localStorage.getItem('product' + id);
    if (productQuantity === null) {
        productQuantity = 1;
    } else if (parseInt(productQuantity) === 0) {
        return;
    }

    productQuantity = parseInt(productQuantity) - 1;

    if (productQuantity === 0) {
        deleteProduct(id);
    }

    localStorage.setItem('product' + id, productQuantity);

    let totalQuantity = localStorage.getItem('totalQuantity');

    totalQuantity = (totalQuantity === null) ? 0 : parseInt(totalQuantity) - 1;
    localStorage.setItem('totalQuantity', totalQuantity);

    document.getElementById('basket-products-quantity').innerHTML = totalQuantity;
}

function storeProduct(id) {
    let storedProducts = JSON.parse(localStorage.getItem("products"));
    if (storedProducts === null) {
        storedProducts = [];
    }

    if (!storedProducts.includes(id)) {
        storedProducts.push(id);
    }

    localStorage.setItem("products", JSON.stringify(storedProducts));
}

function deleteProduct(id) {
    let storedProducts = JSON.parse(localStorage.getItem("products"));
    if (storedProducts === null) {
        return;
    }

    storedProducts = storedProducts.filter(function(product) {
        return product !== id;
    })

    localStorage.setItem("products", JSON.stringify(storedProducts));
}