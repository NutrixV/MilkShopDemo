@extends('layouts.app')

@section('title', $product->name . ' | Молочна продукція')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@section('content')
<div class="breadcrumbs-wrapper">
    <div class="container">
        <div class="product-breadcrumbs">
            <a href="/">Додому</a> / <a href="/category">Каталог</a> / 
            @if ($product->category)
                <a href="{{ route('category.show', $product->category->id) }}">{{ $product->category->name }}</a> / 
            @endif
            {{ $product->name }}
        </div>
    </div>
</div>

<div class="product-page">
    <div class="product-main">
        <div class="product-image-block">
            <img src="/images/{{ $product->image ?? 'product-placeholder.svg' }}" alt="{{ $product->name }}" class="product-img-lg">
        </div>
        <div class="product-info-block">
            <h1 class="product-title">{{ $product->name }}</h1>
            
            <div class="product-price-lg">{{ number_format($product->price, 2) }} грн</div>
            <div class="product-desc">
                {{ $product->description ?? 'Немає опису.' }}
            </div>
            <form class="add-to-cart-form" method="POST" action="#">
                <div class="product-qty">
                    <button type="button" class="qty-btn" onclick="changeQty(-1)">-</button>
                    <input type="number" name="quantity" value="1" min="1" class="qty-input">
                    <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                </div>
                <button type="submit" class="add-to-cart-btn-lg" onclick="event.preventDefault(); addToCartWithQty({id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', price: {{ $product->price }}, image: '/images/{{ $product->image ?? 'product-placeholder.svg' }}'})">Додати в кошик</button>
            </form>
            <ul class="product-attrs" style="list-style:none;padding:0;margin:32px 0 0 0;font-size:18px;max-width:600px;">
                <li><b>Наявність:</b> {{ $product->in_stock ? 'В наявності' : 'Немає' }}</li>
                @if($product->fat_content)
                    <li><b>Жирність:</b> {{ $product->fat_content }}</li>
                @endif
                @if($product->volume)
                    <li><b>Обʼєм:</b> {{ $product->volume }} {{ $product->unit ?? 'ml' }}</li>
                @endif
                @if($product->expiration_date)
                    <li><b>Термін придатності:</b> {{ \Carbon\Carbon::parse($product->expiration_date)->format('d.m.Y') }}</li>
                @endif
                @if($product->manufacturer)
                    <li><b>Виробник:</b> {{ $product->manufacturer }}</li>
                @endif
                @if($product->storage_temp)
                    <li><b>Температура зберігання:</b> {{ $product->storage_temp }}</li>
                @endif
                <li><b>Органічний продукт:</b> {{ $product->is_organic ? 'Так' : 'Ні' }}</li>
            </ul>
        </div>
    </div>
</div>
<script>
function changeQty(delta) {
    const input = document.querySelector('.qty-input');
    let val = parseInt(input.value) || 1;
    val = Math.max(1, val + delta);
    input.value = val;
}

function addToCartWithQty(product) {
    const qtyInput = document.querySelector('.qty-input');
    const qty = parseInt(qtyInput.value) || 1;
    
    // Викликаємо основну функцію addToCart з параметром кількості
    addToCart(product, qty);
}
</script>
@endsection
