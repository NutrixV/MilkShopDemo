<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dairy Shop')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('favicon-180x180.png') }}">
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', Arial, sans-serif; background: #fcfcfc; margin: 0; }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>
<body>

<div class="site-wrapper">
    <div class="site-content">
        <header class="header">
            <div class="header-content">
                <div class="logo-block">
                    <a href="/">
                        <svg width="56" height="72" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="12" y="12" width="32" height="48" rx="16" stroke="#409EFF" stroke-width="6"/><rect x="18" y="6" width="20" height="12" rx="8" stroke="#409EFF" stroke-width="6"/></svg>
                        <span class="logo-text">Milk Shop</span>
                    </a>
                </div>
                <nav class="main-nav">
                    <a href="/" class="nav-link">Додому</a>
                    <a href="/category" class="nav-link">Каталог</a>
                    <a href="/about" class="nav-link">Про нас</a>
                </nav>
                <div class="header-icons">
                    <span class="icon user-icon" onclick="toggleUserMenu(event)">
                        <svg width="20" height="20" viewBox="0 0 32 32" fill="none" stroke="#222" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><circle cx="16" cy="12" r="6"/><path d="M4 28c0-6 8-8 12-8s12 2 12 8"/></svg>
                        <div id="user-menu" class="user-menu">
                            @php
                                $customerId = session('customer_id');
                                $customer = $customerId ? \App\Models\Customer::find($customerId) : null;
                            @endphp
                            @if($customer)
                                <span style="padding: 12px 24px; font-weight: bold;">{{ $customer->name }}</span>
                                <a href="{{ route('customer') }}">Кабінет</a>
                                <a href="#" onclick="logoutCustomer(event)">Logout</a>
                            @else
                                <a href="#" onclick="openLoginPopup(event)">Login</a>
                                <a href="#" onclick="openRegisterPopup(event)">Create Account</a>
                            @endif
                        </div>
                    </span>
                    <span class="icon cart-icon" onclick="openCartPopup(event)">
                        <svg width="20" height="20" viewBox="0 0 32 32" fill="none" stroke="#222" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="27" r="2"/>
                            <circle cx="23" cy="27" r="2"/>
                            <path d="M4 6h2l3 14h14l3-10H8"/>
                        </svg>
                    </span>
                </div>
            </div>
        </header>
        <main class="main-content">
            @yield('content')
        </main>
    </div>
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left"> 2025 Milk Shop</div>
            <div class="footer-center">
                <a href="#" class="footer-link">Конфіденційність</a>
                <a href="#" class="footer-link">Умови обслуговування</a>
            </div>
            <div class="footer-right">
                <a href="#" class="footer-link">Контакти</a>
            </div>
        </div>
    </footer>
</div>
<div id="register-popup" class="register-popup">
    <div class="register-popup-content">
        <span class="close-btn" onclick="closeRegisterPopup()">&times;</span>
        <h2>Register</h2>
        <form id="register-form">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="register-btn">Register</button>
        </form>
    </div>
</div>
<div id="login-popup" class="login-popup">
    <div class="login-popup-content">
        <span class="close-btn" onclick="closeLoginPopup()">&times;</span>
        <h2>Login</h2>
        <form id="login-form">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <label for="login-email">Email:</label>
            <input type="email" id="login-email" name="email" required>
            <label for="login-password">Password:</label>
            <input type="password" id="login-password" name="password" required>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</div>
<div id="cart-popup" class="cart-popup">
    <div class="cart-popup-content">
        <span class="close-btn" onclick="closeCartPopup()">&times;</span>
        <h2>Кошик</h2>
        <div id="cart-items">
            <p class="cart-empty">Кошик порожній</p>
        </div>
        <div class="cart-popup-actions">
            <a href="{{ route('cart') }}" class="view-cart-btn">Перейти в кошик</a>
            <button class="checkout-btn" onclick="checkoutCart()">Оформити замовлення</button>
        </div>
    </div>
</div>
<script>
function toggleUserMenu(e) {
    e.stopPropagation();
    const menu = document.getElementById('user-menu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}
document.addEventListener('click', function(e) {
    const menu = document.getElementById('user-menu');
    if (menu && menu.style.display === 'block') {
        menu.style.display = 'none';
    }
});
function openLoginPopup(e) {
    if(e) e.preventDefault();
    const popup = document.getElementById('login-popup');
    if(popup) popup.style.display = 'block';
    const menu = document.getElementById('user-menu');
    if(menu) menu.style.display = 'none';
}
function openRegisterPopup(e) {
    if(e) e.preventDefault();
    const popup = document.getElementById('register-popup');
    if(popup) popup.style.display = 'block';
    const menu = document.getElementById('user-menu');
    if(menu) menu.style.display = 'none';
}
function closeLoginPopup() {
    const popup = document.getElementById('login-popup');
    if(popup) popup.style.display = 'none';
}
function closeRegisterPopup() {
    const popup = document.getElementById('register-popup');
    if(popup) popup.style.display = 'none';
}
function logoutCustomer(e) {
    e.preventDefault();
    fetch('/logout-customer', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    }).then(() => {
        location.reload();
    });
}
function openCartPopup(e) {
    if(e) e.stopPropagation();
    document.getElementById('cart-popup').style.display = 'block';
}
function closeCartPopup() {
    document.getElementById('cart-popup').style.display = 'none';
}
document.addEventListener('click', function(e) {
    const cartPopup = document.getElementById('cart-popup');
    if (cartPopup && cartPopup.style.display === 'block' && !cartPopup.contains(e.target) && !e.target.classList.contains('cart-icon')) {
        cartPopup.style.display = 'none';
    }
});

// Підключаємо окремі JavaScript файли
</script>
<script src="/js/accordion.js"></script>
<script src="/js/cart.js"></script>
<script src="/js/auth.js"></script>
<script src="/js/cart-page.js"></script>
</body>
</html>
