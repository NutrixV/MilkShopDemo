@extends('layouts.app')

@section('title', 'Пошук: ' . request()->input('query', '') . ' | Молочна продукція')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endpush

@section('content')
<div class="search-page">
    <div class="search-header">
        <h1 class="search-title">Результати пошуку</h1>
        <div class="search-form-container">
            <form action="/search" method="GET" class="search-form">
                <input type="text" name="query" value="{{ request()->input('query', '') }}" 
                       placeholder="Пошук продуктів..." class="search-input">
                <button type="submit" class="search-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
        </div>
        
        @if(request()->has('query') && !empty(request()->input('query')))
            <p class="search-summary">
                Знайдено {{ $products->total() }} результатів для "<strong>{{ request()->input('query') }}</strong>"
            </p>
        @endif
        
        <div class="search-filters">
            <form action="/search" method="GET" class="filter-form">
                <input type="hidden" name="query" value="{{ request()->input('query', '') }}">
                
                <div class="filter-group">
                    <label for="category" class="filter-label">Категорія:</label>
                    <select name="category" id="category" class="filter-select">
                        <option value="">Всі категорії</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ request()->input('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="sort" class="filter-label">Сортувати за:</label>
                    <select name="sort" id="sort" class="filter-select">
                        <option value="relevance" {{ request()->input('sort') == 'relevance' ? 'selected' : '' }}>
                            Релевантністю
                        </option>
                        <option value="price_asc" {{ request()->input('sort') == 'price_asc' ? 'selected' : '' }}>
                            Ціна (зростання)
                        </option>
                        <option value="price_desc" {{ request()->input('sort') == 'price_desc' ? 'selected' : '' }}>
                            Ціна (спадання)
                        </option>
                        <option value="name_asc" {{ request()->input('sort') == 'name_asc' ? 'selected' : '' }}>
                            Назва (А-Я)
                        </option>
                        <option value="name_desc" {{ request()->input('sort') == 'name_desc' ? 'selected' : '' }}>
                            Назва (Я-А)
                        </option>
                    </select>
                </div>
                
                <div class="filter-group filter-checkbox-group">
                    <label class="filter-checkbox">
                        <input type="checkbox" name="in_stock" value="1" 
                               {{ request()->has('in_stock') ? 'checked' : '' }}>
                        <span class="checkbox-text">Тільки в наявності</span>
                    </label>
                </div>
                
                <button type="submit" class="filter-button">Застосувати</button>
            </form>
        </div>
    </div>
    
    <div class="search-results">
        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <a href="/product/{{ $product->id }}" class="product-card">
                        <img src="/images/{{ $product->image ?? 'product-placeholder.svg' }}" alt="{{ $product->name }}" class="product-img">
                        <div class="product-info">
                            <h2 class="product-name">{{ $product->name }}</h2>
                            @if($product->category)
                                <div class="product-category">{{ $product->category->name }}</div>
                            @endif
                            <div class="product-price">{{ number_format($product->price, 2) }} грн</div>
                            
                            <div class="product-availability {{ $product->in_stock ? 'in-stock' : 'out-of-stock' }}">
                                {{ $product->in_stock ? 'В наявності' : 'Немає в наявності' }}
                            </div>
                            
                            <button class="add-to-cart-btn" type="button" 
                                   onclick="event.stopPropagation(); event.preventDefault(); addToCart({
                                       id: {{ $product->id }}, 
                                       name: '{{ addslashes($product->name) }}', 
                                       price: {{ $product->price }}, 
                                       image: '/images/{{ $product->image ?? 'product-placeholder.svg' }}'
                                   })">
                                Додати в кошик
                            </button>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="pagination-container">
                {{ $products->appends(request()->query())->links('pagination::compact') }}
            </div>
        @else
            <div class="no-results">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    <line x1="8" y1="11" x2="14" y2="11"></line>
                </svg>
                <h3>Нічого не знайдено</h3>
                <p>Спробуйте змінити запит або параметри пошуку</p>
            </div>
        @endif
    </div>
</div>
@endsection 