@extends('layouts.app')

@section('content')
<div class="cart-page">
    <h1 class="cart-title">Кошик</h1>
    <div class="cart-table-wrapper">
        <div class="table-responsive">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th style="text-align: left; padding-left: 20px;">Продукт</th>
                        <th>Ціна</th>
                        <th>Кількість</th>
                        <th>Сума</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cart-table-body">
                    <!-- JS will render cart items here -->
                </tbody>
            </table>
        </div>
        <div class="cart-summary">
            <div class="subtotal-label">Загальна сума</div>
            <div class="subtotal-value" id="cart-subtotal">0 грн</div>
        </div>
        <div class="cart-actions">
            <a href="/" class="checkout-btn continue-shopping-btn">Продовжити покупки</a>
            <button class="checkout-btn clear-cart-btn" onclick="clearCart()">Очистити кошик</button>
            <button class="checkout-btn checkout-order-btn" onclick="checkoutCart()">Оформити замовлення</button>
        </div>
    </div>
</div>
<script src="/js/cart-page.js"></script>
@endsection
