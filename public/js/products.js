document.addEventListener("DOMContentLoaded", function() {
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
    
    const cookieAdmin = getCookie('isAdmin');
    const cookieUser = getCookie('userEmail');
    
    if(!cookieAdmin && !cookieUser){
        window.location.href = '/src/views/login.html';

    }
        
    const buyButtons = document.querySelectorAll('.buy-button');

    let cartItems = JSON.parse(localStorage.getItem('cart')) || [];  

    buyButtons.forEach(button => {
        button.addEventListener('click', function() {
            
            const productId = this.getAttribute('data-id');

            let existingProduct = cartItems.find(item => item.id === productId);

            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                cartItems.push({
                    id: productId, 
                    quantity: 1 
                });
            }

            localStorage.setItem('cart', JSON.stringify(cartItems));
        });
    });
});
