// Cart logic
function getCart() {
    return JSON.parse(localStorage.getItem('cart') || '[]');
}

function setCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
}

function addToCart(product, quantity = 1) {
    let cart = getCart();
    const idx = cart.findIndex(item => item.id === product.id);
    
    // Переконуємося, що ми маємо всі необхідні дані
    const processedProduct = {
        id: product.id,
        name: product.name,
        price: product.price,
        image: product.image || null
    };
    
    if (idx > -1) {
        cart[idx].qty += parseInt(quantity);
    } else {
        cart.push({...processedProduct, qty: parseInt(quantity)});
    }
    
    setCart(cart);
    renderCart();
    openCartPopup();
}

function renderCart() {
    const cart = getCart();
    const cartItems = document.getElementById('cart-items');
    if (!cartItems) return;

    if (!cart.length) {
        cartItems.innerHTML = '<p class="cart-empty">Кошик порожній</p>';
        return;
    }
    cartItems.innerHTML = cart.map(item =>
        `<div class="cart-item">
            <span class="cart-item-name" style="text-align: left;">${item.name}</span>
            <span class="cart-item-qty">x${item.qty}</span>
            <span class="cart-item-price">${item.price} грн</span>
            <button class="cart-item-remove" onclick="removeFromCart(${item.id})">✕</button>
        </div>`
    ).join('');
}

function updateCartQty(id, qty) {
    qty = parseInt(qty);
    if (qty <= 0) {
        removeFromCart(id);
        return;
    }
    
    let cart = getCart();
    cart = cart.map(item => item.id === id ? {...item, qty: qty} : item);
    setCart(cart);
    renderFullCart && renderFullCart();
    renderCart();
}

function removeFromCart(id) {
    let cart = getCart().filter(item => item.id !== id);
    setCart(cart);
    renderFullCart && renderFullCart();
    renderCart();
}

function clearCart() {
    setCart([]);
    renderFullCart && renderFullCart();
    renderCart();
}

function checkoutCart() {
    alert('Checkout is not implemented.');
}

// Функція для відображення кількості товарів у кошику
function updateCartCount() {
    const cart = getCart();
    const totalItems = cart.reduce((sum, item) => sum + parseInt(item.qty), 0);
    
    // Знаходимо або створюємо елемент для відображення кількості
    let cartCountElement = document.getElementById('cart-counter');
    
    if (!cartCountElement) {
        cartCountElement = document.createElement('span');
        cartCountElement.id = 'cart-counter';
        cartCountElement.className = 'cart-counter';
        
        // Знаходимо іконку кошика та додаємо до неї лічильник
        const cartIcon = document.querySelector('.cart-icon');
        if (cartIcon) {
            cartIcon.appendChild(cartCountElement);
        }
    }
    
    // Оновлюємо вміст лічильника та його видимість
    if (totalItems > 0) {
        cartCountElement.textContent = totalItems;
        cartCountElement.style.display = 'block';
    } else {
        cartCountElement.style.display = 'none';
    }
}

// Ініціалізація кошика при завантаженні сторінки
document.addEventListener('DOMContentLoaded', function() {
    renderCart();
    updateCartCount();
}); 