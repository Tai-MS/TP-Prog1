const $productos = document.querySelector('#form-button');
const $listaProductos = document.querySelector('#product-list');

window.addEventListener('DOMContentLoaded', e => {
    const cartItems = JSON.parse(localStorage.getItem('cart'));
    if (cartItems) {
        const product = cartItems.map(object => {
            return { 'id': object.id, 'quantity': object.quantity };
        });

        product.forEach(element => {
            fetch('../../public/purchase-handler.php', {
                method: 'POST',
                body: JSON.stringify({ 'productsID': [element.id] }),
                headers: { 'Content-Type': 'application/json' }
            })
            .then(data => data.json())
            .then(data => {
                data.quantity = element.quantity;
                frontData(data);
            })
            .catch(err => console.log(err));
        });
    } else {
        const $alert = document.createElement('div');
        $alert.className = 'alert alert-warning';
        $alert.innerHTML = 'Por el momento, no hay artículos en el carrito';
        $listaProductos.appendChild($alert);
    }
});

$productos.addEventListener('submit', e => {
    e.preventDefault();
    const $productsID = Array.from(document.querySelectorAll('.bought-products'))
        .map(product => product.id);

    const $quantity = Array.from(document.querySelectorAll('.quantity-products'))
        .map(input => input.id);

    const dataForm = {
        'userEMail': document.cookie.replace('userEmail=', '').replace('%', '@'),
        'productsID': $productsID,
        'quantity': $quantity
    };

    console.log(dataForm);

    fetch('../../public/purchase-handler.php', {
        method: 'POST',
        body: JSON.stringify(dataForm),
        headers: { 'Content-Type': 'application/json' }
    })
    .then(data => data.json())
    .then(data => dataHandler(data))
    .catch(err => console.log(err));

    const dataHandler = (data) => {
        console.log(data);
        // window.location.href = '../../src/views/ticket.html';
    };
});

function frontData(data) {
    const $ul = document.createElement('ul');
    $ul.className = 'list-group mb-3';

    const $liProduct = document.createElement('li');
    $liProduct.className = 'bought-products list-group-item d-flex justify-content-between align-items-center';
    $liProduct.id = data.id;
    $liProduct.textContent = `${data.name}: $${data.price}`;

    const $labelQuantity = document.createElement('span');
    $labelQuantity.className = 'quantity-products badge bg-primary rounded-pill';
    $labelQuantity.id = data.quantity;
    $labelQuantity.textContent = `Cantidad: ${data.quantity}`;

    const $deleteButton = document.createElement('button');
    $deleteButton.className = 'btn btn-danger btn-sm ms-2';
    $deleteButton.onclick = () => deleteItemCart(data.id);
    $deleteButton.textContent = 'Eliminar';

    $liProduct.appendChild($labelQuantity);
    $liProduct.appendChild($deleteButton);
    $ul.appendChild($liProduct);
    $listaProductos.appendChild($ul);
}

function deleteItemCart(id) {
    console.log(`Producto con ID ${id} eliminado`);
}
