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
                        <svg class="logo-svg" viewBox="0 0 56 72" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="12" y="12" width="32" height="48" rx="16" stroke="#409EFF" stroke-width="6"/><rect x="18" y="6" width="20" height="12" rx="8" stroke="#409EFF" stroke-width="6"/></svg>
                        <span class="logo-text">Milk Shop</span>
                    </a>
                </div>
                <nav class="main-nav" id="main-nav">
                    <a href="/" class="nav-link">Додому</a>
                    <a href="/category" class="nav-link">Каталог</a>
                    <a href="/about" class="nav-link">Про нас</a>
                </nav>
                <div class="header-search desktop-search">
                    <form action="/search" method="GET" class="search-form-header">
                        <input type="text" name="query" placeholder="Пошук продуктів..." class="search-input-header" required>
                        <button type="submit" class="search-button-header">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                    </form>
                </div>
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
                                <a href="{{ route('customer.profile') }}">Кабінет</a>
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
                <div class="mobile-menu-toggle" id="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </header>
        
        <!-- Мобільне поле пошуку під хедером -->
        <div class="mobile-search-container">
            <form action="/search" method="GET" class="mobile-search-form">
                <input type="text" name="query" placeholder="Пошук продуктів..." class="mobile-search-input" required>
                <button type="submit" class="mobile-search-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
        </div>
        
        <main class="main-content">
            @yield('content')
        </main>
    </div>
    
    <!-- Футер роздільник -->
    <div class="footer-divider"></div>
    
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <div class="footer-logo">
                    <svg class="footer-logo-svg" viewBox="0 0 56 72" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="12" y="12" width="32" height="48" rx="16" stroke="#409EFF" stroke-width="6"/><rect x="18" y="6" width="20" height="12" rx="8" stroke="#409EFF" stroke-width="6"/></svg>
                    <span class="footer-logo-text">Milk Shop</span>
                </div>
                <div class="footer-copyright">© 2025 Всі права захищені</div>
            </div>
            
            <div class="footer-center">
                <h4 class="footer-heading">Інформація</h4>
                <a href="#" class="footer-link">Конфіденційність</a>
                <a href="#" class="footer-link">Умови обслуговування</a>
                <a href="#" class="footer-link">Доставка</a>
            </div>
            
            <div class="footer-right">
                <h4 class="footer-heading">Контакти</h4>
                <a href="tel:+380501234567" class="footer-link">+38 (050) 123-45-67</a>
                <a href="mailto:info@milkshop.com" class="footer-link">info@milkshop.com</a>
                <div class="footer-social">
                    <a href="#" class="social-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                    </a>
                    <a href="#" class="social-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                    <a href="#" class="social-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                    </a>
                </div>
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

// Функції для мобільного меню
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mainNav = document.getElementById('main-nav');
    
    if (mobileMenuToggle && mainNav) {
        mobileMenuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            mainNav.classList.toggle('active');
        });
        
        // Закривати меню при натисканні на пункт меню
        const navLinks = mainNav.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenuToggle.classList.remove('active');
                mainNav.classList.remove('active');
            });
        });
        
        // Закривати меню при кліку поза меню
        document.addEventListener('click', function(e) {
            if (!mainNav.contains(e.target) && !mobileMenuToggle.contains(e.target) && mainNav.classList.contains('active')) {
                mobileMenuToggle.classList.remove('active');
                mainNav.classList.remove('active');
            }
        });
        
        // Перевіряємо розмір вікна при змінії
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && mainNav.classList.contains('active')) {
                mobileMenuToggle.classList.remove('active');
                mainNav.classList.remove('active');
            }
        });
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
