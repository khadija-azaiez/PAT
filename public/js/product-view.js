function toggleProduct(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {

            const btn = document.getElementById('btn-toggle-product');
            if (btn.classList.contains('btn-success')) {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-danger');
                btn.innerHTML = 'A activer';
            } else if (btn.classList.contains('btn-danger')) {
                btn.classList.add('btn-success');
                btn.classList.remove('btn-danger');
                btn.innerHTML = 'A désactiver';
            }
        }
    };
    xhr.open('GET', '/product/toggle/' + id);
    xhr.send();
}

function toggleProduct2(id) {
    $.get('/product/toggle/' + id, function (data, status) {
        if (status === 'success') {
            const btn = $("#btn-toggle-product");

            if (btn.hasClass( "btn-success" )) {
                btn.removeClass( "btn-success" );
                btn.addClass('btn-danger');
                btn.html('A activer');
            } else if (btn.hasClass( "btn-danger" )) {
                btn.addClass( "btn-success" );
                btn.removeClass('btn-danger');
                btn.html('A désactiver');
            }
        }
    });
}