@extends('layouts.app')

@section('title', $category->name . ' | Dairy Shop')

@section('content')
<meta name="category-id" content="{{ $category->id }}">
<div class="category-page" data-category-id="{{ $category->id }}">
    <div class="category-sidebar">
        <div class="accordions-wrapper">
            <form method="GET" class="sidebar-filters">
                <div style="margin-top:16px;">
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

@endsection
