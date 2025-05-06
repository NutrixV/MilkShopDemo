@extends('layouts.app')

@section('title', $category->name . ' | Dairy Shop')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/category.css') }}">
@endpush

@section('content')
<meta name="category-id" content="{{ $category->id }}">
<div class="category-page" data-category-id="{{ $category->id }}">
    <button id="filter-toggle" class="filter-toggle-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
        </svg>
        Фільтри
    </button>
    
    <div class="category-sidebar">
        <div class="mobile-filter-header">
            <h3>Фільтри</h3>
            <button id="close-filters" class="close-filters-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="accordions-wrapper">
            <form method="GET" class="sidebar-filters">
                <div class="filter-buttons" style="margin-top:16px;">
                    <button type="submit" class="btn btn-primary">Фільтрувати</button>
                    <a href="?" class="btn btn-light" id="reset-filters">Скинути</a>
                </div>
                <div class="accordion">
                    <div class="accordion-item">
                        <button type="button" class="accordion-toggle active">Категорії</button>
                        <div class="accordion-content" style="display:block;">
                            <ul class="categories-list-vertical">
                                @foreach ($categories as $cat)
                                    <li>
                                        <a href="{{ route('category.show', $cat->id) }}" class="category-link @if($cat->id === $category->id) active @endif">{{ $cat->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button type="button" class="accordion-toggle">Жирність</button>
                        <div class="accordion-content">
                            @foreach($fatContents as $fat => $count)
                                @if($fat !== null && $fat !== '')
                                <label>
                                    <input type="checkbox" name="fat_content[]" value="{{ $fat }}" {{ in_array($fat, request()->input('fat_content', [])) ? 'checked' : '' }}>
                                    <span class="filter-count">({{ $count }})</span> {{ $fat }}%
                                </label><br>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button type="button" class="accordion-toggle">Обʼєм</button>
                        <div class="accordion-content">
                            @foreach($volumes as $vol => $count)
                                @if($vol !== null && $vol !== '')
                                <label>
                                    <input type="checkbox" name="volume[]" value="{{ $vol }}" {{ in_array($vol, request()->input('volume', [])) ? 'checked' : '' }}>
                                    <span class="filter-count">({{ $count }})</span> {{ $vol }} мл
                                </label><br>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button type="button" class="accordion-toggle">Виробник</button>
                        <div class="accordion-content">
                            @foreach($manufacturers as $man => $count)
                                @if($man !== null && $man !== '')
                                <label>
                                    <input type="checkbox" name="manufacturer[]" value="{{ $man }}" {{ in_array($man, request()->input('manufacturer', [])) ? 'checked' : '' }}>
                                    <span class="filter-count">({{ $count }})</span> {{ $man }}
                                </label><br>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button type="button" class="accordion-toggle">Органічний продукт</button>
                        <div class="accordion-content">
                            @foreach($isOrganics as $org => $count)
                                <label>
                                    <input type="checkbox" name="is_organic[]" value="{{ $org }}" {{ in_array($org, request()->input('is_organic', [])) ? 'checked' : '' }}>
                                    <span class="filter-count">({{ $count }})</span> {{ $org == 1 ? 'Так' : 'Ні' }}
                                </label><br>
                            @endforeach
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button type="button" class="accordion-toggle">Наявність</button>
                        <div class="accordion-content">
                            @foreach($inStocks as $stock => $count)
                                <label>
                                    <input type="checkbox" name="in_stock[]" value="{{ $stock }}" {{ in_array($stock, request()->input('in_stock', [])) ? 'checked' : '' }}>
                                    <span class="filter-count">({{ $count }})</span> {{ $stock == 1 ? 'В наявності' : 'Немає' }}
                                </label><br>
                            @endforeach
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button type="button" class="accordion-toggle">Температура зберігання</button>
                        <div class="accordion-content">
                            @foreach($storageTemps as $temp => $count)
                                @if($temp !== null && $temp !== '')
                                <label>
                                    <input type="checkbox" name="storage_temp[]" value="{{ $temp }}" {{ in_array($temp, request()->input('storage_temp', [])) ? 'checked' : '' }}>
                                    <span class="filter-count">({{ $count }})</span> {{ $temp }}
                                </label><br>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button type="button" class="accordion-toggle">Термін придатності</button>
                        <div class="accordion-content">
                            @foreach($expirationDates as $exp => $count)
                                @if($exp !== null && $exp !== '')
                                <label>
                                    <input type="checkbox" name="expiration_date[]" value="{{ $exp }}" {{ in_array($exp, request()->input('expiration_date', [])) ? 'checked' : '' }}>
                                    <span class="filter-count">({{ $count }})</span> {{ \Carbon\Carbon::parse($exp)->format('d.m.Y') }}
                                </label><br>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button type="button" class="accordion-toggle">Ціна</button>
                        <div class="accordion-content">
                            @foreach($priceRanges as $range => $count)
                                <label>
                                    <input type="checkbox" name="price[]" value="{{ $range }}" {{ in_array($range, request()->input('price', [])) ? 'checked' : '' }}>
                                    <span class="filter-count">({{ $count }})</span>
                                    @if($range === '0-50') до 50 грн
                                    @elseif($range === '50-100') 50-100 грн
                                    @elseif($range === '100-200') 100-200 грн
                                    @else 200+ грн
                                    @endif
                                </label><br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="category-products">
        <h1 class="category-title">{{ $category->name }}</h1>
        <div class="category-products-list">
            @forelse ($products as $product)
                <a href="{{ route('product.show', $product->id) }}" class="product-card product-link">
                    <img src="/images/{{ $product->image ?? 'product-placeholder.svg' }}" alt="{{ $product->name }}" class="product-img">
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-price">{{ number_format($product->price, 2) }} грн</div>
                    <button class="add-to-cart-btn" type="button" onclick="event.stopPropagation(); event.preventDefault(); addToCart({id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', price: {{ $product->price }}, image: '/images/{{ $product->image ?? 'product-placeholder.svg' }}'})">Додати в кошик</button>
                </a>
            @empty
                <div class="no-products">Ще немає продуктів в цій категорії.</div>
            @endforelse
        </div>
        <div class="pagination-wrapper">
            {{ $products->links('pagination::compact') }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter toggle functionality for mobile
    const filterToggleBtn = document.getElementById('filter-toggle');
    const closeFiltersBtn = document.getElementById('close-filters');
    const sidebar = document.querySelector('.category-sidebar');
    
    if(filterToggleBtn && sidebar && closeFiltersBtn) {
        filterToggleBtn.addEventListener('click', function() {
            sidebar.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scrolling when filter is open
        });
        
        closeFiltersBtn.addEventListener('click', function() {
            sidebar.classList.remove('active');
            document.body.style.overflow = ''; // Restore scrolling
        });
    }
});
</script>
@endsection
