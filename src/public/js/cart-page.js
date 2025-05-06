// Функції для сторінки кошика
function renderFullCart() {
    const cart = getCart();
    const tbody = document.getElementById('cart-table-body');
    const subtotalEl = document.getElementById('cart-subtotal');
    if (!tbody || !subtotalEl) return;
    
    if (!cart.length) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;color:#aaa;font-size:22px;padding:40px 0;">Кошик порожній</td></tr>';
        subtotalEl.textContent = '0 грн';
        return;
    }
    let subtotal = 0;
    tbody.innerHTML = cart.map((item, idx) => {
        const sum = (item.price * item.qty).toFixed(2);
        subtotal += parseFloat(sum);
        
        // Додаємо зображення, якщо воно є
        const imageHtml = item.image ? 
            `<img src="${item.image}" alt="${item.name}" class="cart-product-img">` : 
            `<div class="cart-product-img" style="display:flex;align-items:center;justify-content:center;background:#f0f0f0;color:#aaa;font-size:24px;">?</div>`;
        
        return `<tr>
            <td class="cart-product-info" style="text-align: left; padding-left: 10px;">
                ${imageHtml}
                <span style="font-weight: 500;">${item.name}</span>
            </td>
            <td>${item.price} грн</td>
            <td>
                <div class="product-qty" style="display:inline-flex;align-items:center;justify-content:center;">
                    <button type="button" class="qty-btn" onclick="updateCartQty(${item.id}, Math.max(1, ${item.qty - 1}))" style="font-size:18px;padding:0 8px;min-width:32px;">-</button>
                    <input type="number" min="1" value="${item.qty}" class="cart-qty-input" onchange="updateCartQty(${item.id}, this.value)">
                    <button type="button" class="qty-btn" onclick="updateCartQty(${item.id}, ${item.qty + 1})" style="font-size:18px;padding:0 8px;min-width:32px;">+</button>
                </div>
            </td>
            <td>${sum} грн</td>
            <td><button onclick="removeFromCart(${item.id})" style="background:none;border:none;color:#e00;font-size:22px;cursor:pointer;">&times;</button></td>
        </tr>`;
    }).join('');
    subtotalEl.textContent = subtotal.toFixed(2) + ' грн';
}

// Ініціалізуємо сторінку при завантаженні
document.addEventListener('DOMContentLoaded', function() {
    // Якщо ми на сторінці кошика, рендеримо повний кошик
    if (document.getElementById('cart-table-body')) {
        renderFullCart();
    }
}); 