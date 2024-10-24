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
    
    const $email = getCookieValue('userEmail');

    const $productsID = Array.from(document.querySelectorAll('.bought-products'))
    .map(product => product.id);

    const $quantity = Array.from(document.querySelectorAll('.quantity-products'))
        .map(input => input.id);
        
    const dataForm = {
    "userEMail": $email,
    "productsID": $productsID,
    "quantity": $quantity,
    "action": "buy"
    };

    fetch('../../public/purchase-handler.php', {
        method: 'POST',
        body: JSON.stringify(dataForm),
        headers: {'Content-Type': 'application/json'}
    })
    .then(data => data.json())
    .then(data => dataHandler(data))
    .catch(err => console.log(err));
    
    const dataHandler = (data) => {
        window.location.href = '../views/products.html';
        localStorage.clear();

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
    $deleteButton.onclick = () => deleteItemCart(data);
    $deleteButton.textContent = 'Eliminar';
    
    $liProduct.appendChild($labelQuantity);
    $liProduct.appendChild($deleteButton);
    $ul.appendChild($liProduct);
    $listaProductos.appendChild($ul);
}

function deleteItemCart(data) {
    let cart = JSON.parse(localStorage.getItem('cart')) || []; 
    console.log("-----------");
    console.log(data);
    console.log("-----------");

    // Find the item in the cart
    let itemIndex = cart.findIndex(item => parseInt(item.id) === parseInt(data.id));
   
    console.log('itemIndex', itemIndex);
    
    if (itemIndex !== -1) { 
        if (cart[itemIndex].quantity > 1) {
            let newQuantity = cart[itemIndex].quantity -= 1; 
            const $productElement = document.getElementById(data.id);
            console.log("PRODUCTELEMNET ++++++++",$productElement.querySelector('.quantity-products'));
            console.log("PRODUCTELEMNET ++++++++",$productElement);
            
            $productElement.querySelector('.quantity-products').textContent  = `Cantidad: ${newQuantity}`
        } else {
            cart.splice(itemIndex, 1); 
            const $productElement = document.getElementById(data.id);
            if ($productElement) {
                $productElement.remove(); 
            }
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    console.log('Updated cart:', cart);
}

function getCookieValue (name) {
    const match = document.cookie.split('; ').find(row => row.startsWith(`${name}=`));
    return match ? decodeURIComponent(match.split('=')[1]) : '';
};