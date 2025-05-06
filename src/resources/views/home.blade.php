@extends('layouts.app')

@section('title', 'Dairy Shop')

@section('content')
<div class="homepage-hero">
    <div class="hero-left">
        <h1 class="hero-title">Молочна<br>Продукція</h1>
        <p class="hero-desc">Відкрийте для себе широкий спектр<br>і високоякісних молочних продуктів.</p>
        <a href="/category" class="hero-btn">Купити</a>
    </div>
    <div class="hero-right">
        <img src="/images/milkProduction.png" alt="Виробництво молока" class="hero-img">
    </div>
</div>

<div class="homepage-categories">
    <h2 class="categories-title">Категорії</h2>
    <div class="categories-list">
        @foreach ($categories as $category)
            <a href="{{ route('category.show', $category->id) }}" class="category-chip">{{ $category->name }}</a>
        @endforeach
    </div>
</div>

<div class="homepage-featured">
    <h2 class="featured-title">Рекомендовані продукти</h2>
    <div class="featured-list">
        @foreach ($products->take(4) as $product)
        <a href="{{ route('product.show', $product->id) }}" class="product-card product-link">
    <img src="/images/{{ $product->image ?? 'product-placeholder.svg' }}" alt="{{ $product->name }}" class="product-img">
    <div class="product-name">{{ $product->name }}</div>
    <div class="product-price">{{ number_format($product->price, 2) }} грн</div>
    <button class="add-to-cart-btn" type="button" onclick="event.stopPropagation(); event.preventDefault(); addToCart({id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', price: {{ $product->price }}, image: '/images/{{ $product->image ?? 'product-placeholder.svg' }}'})">Додати в кошик</button>
</a>
        @endforeach
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="/css/home.css">
@endpush
