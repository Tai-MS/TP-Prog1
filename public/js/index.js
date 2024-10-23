const $productos = document.querySelector('#products-button');
const $carrito = document.querySelector('#cart');

$productos.addEventListener('click', e=> {
    window.location.href = '../views/products.html';
})

$carrito.addEventListener('click', e=> {
    window.location.href = '../views/cart.html';
})