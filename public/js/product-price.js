function changePrice(id) {
    console.log('ok');
    var price = document.getElementById('product-new-price').value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            const btn = document.getElementById('button-ok');
            btn.disabled = true;
            document.getElementById("product-new-price").disabled = true;
           const newprice = document.getElementById("product-price");
            newprice.innerHTML = price;

        }
    };



    var data = new FormData();
    data.append('price', price);

    xhr.open('POST', '/product/change/' + id);
    xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
    xhr.send(data);
}