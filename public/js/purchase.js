const $productos = document.querySelector('#products-button');
const $cookies = document.$cookies;
const $productsID = document.querySelectorAll('.bought-products');
const $quantity = document.querySelectorAll('.quantity-products');
const $listaProductos = document.querySelector('#product-list');

window.addEventListener('DOMContentLoaded', e=> {
    const cartItems = JSON.parse(localStorage.getItem('cart'));
    if(cartItems) {
        const productId = cartItems.map(object => {
            return object.id;
        });

        const $ul = document.createElement('ul');
        const $li = document.createElement('li');
        const $deleteButton = document.createElement('button');


    } else {
        const $label = document.createElement('label');
        $label.innerHTML = 'Por el momento, no hay artículos en el carrito';
        $listaProductos.appendChild($label);
    }
})

$productos.addEventListener('click', e=> {
    e.preventDefault;
    const body = {
        'userEMail': $cookies.replace('userEmail=', '').replace('%', '@'),
        'productsID': $productsID,
        'quantity': $quantity
    };
    const dataForm = new FormData(body);

    fetch('../purchase-handler.php', {method: 'POST', body: JSON.stringify(dataForm), headers: {'Content-Type': 'application/json'}})
        .then(data => data.json())
            .then(data => dataHandler(data))
                .catch(err => console.log(err));

    const dataHandler = (data) => {
        console.log(data);
        window.location.href = '../../src/views/ticket.html';
    };
})