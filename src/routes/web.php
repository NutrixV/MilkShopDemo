<?php

use Illuminate\Support\Facades\Route;

use App\Models\Category;
use App\Models\Product;

Route::get('/', function () {
    $categories = Category::all();
    $products = Product::all();
    return view('home', compact('categories', 'products'));
});

Route::get('/category/{id}',
    function (
        $id,
        \Illuminate\Http\Request $request
    ) {
        $categories = \App\Models\Category::all();
        $category = \App\Models\Category::findOrFail($id);
        $productsQuery = \App\Models\Product::where('category_id', $id);

        // Фільтрація за жирністю
        if ($request->filled('fat_content')) {
            $productsQuery->whereIn('fat_content', $request->input('fat_content'));
        }
        // Фільтрація за об'ємом
        if ($request->filled('volume')) {
            $productsQuery->whereIn('volume', $request->input('volume'));
        }
        // Фільтрація за виробником
        if ($request->filled('manufacturer')) {
            $productsQuery->whereIn('manufacturer', $request->input('manufacturer'));
        }
        // Фільтрація за органічністю
        if ($request->filled('is_organic')) {
            $productsQuery->whereIn('is_organic', $request->input('is_organic'));
        }
        // Фільтрація за наявністю
        if ($request->filled('in_stock')) {
            $productsQuery->whereIn('in_stock', $request->input('in_stock'));
        }
        // Фільтрація за температурою зберігання
        if ($request->filled('storage_temp')) {
            $productsQuery->whereIn('storage_temp', $request->input('storage_temp'));
        }
        // Фільтрація за терміном придатності
        if ($request->filled('expiration_date')) {
            $productsQuery->whereIn('expiration_date', $request->input('expiration_date'));
        }
        // Фільтрація за ціною (діапазони)
        if ($request->filled('price')) {
            $productsQuery->where(function ($q) use ($request) {
                foreach ($request->input('price') as $range) {
                    if ($range === '0-50') {
                        $q->orWhereBetween('price', [0, 50]);
                    } elseif ($range === '50-100') {
                        $q->orWhereBetween('price', [50.01, 100]);
                    } elseif ($range === '100-200') {
                        $q->orWhereBetween('price', [100.01, 200]);
                    } elseif ($range === '200+') {
                        $q->orWhere('price', '>', 200);
                    }
                }
            });
        }

        $products = $productsQuery->paginate(18);

        // Формування фільтрів з підрахунком
        $baseQuery = \App\Models\Product::where('category_id', $id);
        $fatContents = (clone $baseQuery)
            ->select('fat_content', \DB::raw('count(*) as count'))
            ->groupBy('fat_content')
            ->pluck('count', 'fat_content');
        $volumes = (clone $baseQuery)
            ->select('volume', \DB::raw('count(*) as count'))
            ->groupBy('volume')
            ->pluck('count', 'volume');
        $manufacturers = (clone $baseQuery)
            ->select('manufacturer', \DB::raw('count(*) as count'))
            ->groupBy('manufacturer')
            ->pluck('count', 'manufacturer');
        $isOrganics = (clone $baseQuery)
            ->select('is_organic', \DB::raw('count(*) as count'))
            ->groupBy('is_organic')
            ->pluck('count', 'is_organic');
        $inStocks = (clone $baseQuery)
            ->select('in_stock', \DB::raw('count(*) as count'))
            ->groupBy('in_stock')
            ->pluck('count', 'in_stock');
        $storageTemps = (clone $baseQuery)
            ->select('storage_temp', \DB::raw('count(*) as count'))
            ->groupBy('storage_temp')
            ->pluck('count', 'storage_temp');
        $expirationDates = (clone $baseQuery)
            ->select('expiration_date', \DB::raw('count(*) as count'))
            ->groupBy('expiration_date')
            ->pluck('count', 'expiration_date');
        // Для ціни — діапазони
        $priceRanges = [
            '0-50' => (clone $baseQuery)->whereBetween('price', [0, 50])->count(),
            '50-100' => (clone $baseQuery)->whereBetween('price', [50.01, 100])->count(),
            '100-200' => (clone $baseQuery)->whereBetween('price', [100.01, 200])->count(),
            '200+' => (clone $baseQuery)->where('price', '>', 200)->count(),
        ];

        return view('category', compact(
            'categories', 'category', 'products',
            'fatContents', 'volumes', 'manufacturers', 'isOrganics', 'inStocks', 'storageTemps', 'expirationDates', 'priceRanges'
        ));
    }
)->name('category.show');

Route::get('/product/{id}', function ($id) {
    $product = Product::with('category')->findOrFail($id);
    return view('product', compact('product'));
})->name('product.show');

// About page
Route::view('/about', 'about')->name('about');

// Cart page
Route::view('/cart', 'cart')->name('cart');

// All products page
Route::get('/category', function (\Illuminate\Http\Request $request) {
    $categories = Category::all();
    $productsQuery = Product::query();

    // Фільтрація за жирністю
    if ($request->filled('fat_content')) {
        $productsQuery->whereIn('fat_content', $request->input('fat_content'));
    }
    // Фільтрація за об'ємом
    if ($request->filled('volume')) {
        $productsQuery->whereIn('volume', $request->input('volume'));
    }
    // Фільтрація за виробником
    if ($request->filled('manufacturer')) {
        $productsQuery->whereIn('manufacturer', $request->input('manufacturer'));
    }
    // Фільтрація за органічністю
    if ($request->filled('is_organic')) {
        $productsQuery->whereIn('is_organic', $request->input('is_organic'));
    }
    // Фільтрація за наявністю
    if ($request->filled('in_stock')) {
        $productsQuery->whereIn('in_stock', $request->input('in_stock'));
    }
    // Фільтрація за температурою зберігання
    if ($request->filled('storage_temp')) {
        $productsQuery->whereIn('storage_temp', $request->input('storage_temp'));
    }
    // Фільтрація за терміном придатності
    if ($request->filled('expiration_date')) {
        $productsQuery->whereIn('expiration_date', $request->input('expiration_date'));
    }
    // Фільтрація за ціною (діапазони)
    if ($request->filled('price')) {
        $productsQuery->where(function ($q) use ($request) {
            foreach ($request->input('price') as $range) {
                if ($range === '0-50') {
                    $q->orWhereBetween('price', [0, 50]);
                } elseif ($range === '50-100') {
                    $q->orWhereBetween('price', [50.01, 100]);
                } elseif ($range === '100-200') {
                    $q->orWhereBetween('price', [100.01, 200]);
                } elseif ($range === '200+') {
                    $q->orWhere('price', '>', 200);
                }
            }
        });
    }

    $products = $productsQuery->paginate(12);
    $category = (object)[
        'name' => 'Всі продукти',
        'id' => 0
    ];

    // Формування фільтрів з підрахунком
    $baseQuery = Product::query();
    $fatContents = (clone $baseQuery)
        ->select('fat_content', \DB::raw('count(*) as count'))
        ->groupBy('fat_content')
        ->pluck('count', 'fat_content');
    $volumes = (clone $baseQuery)
        ->select('volume', \DB::raw('count(*) as count'))
        ->groupBy('volume')
        ->pluck('count', 'volume');
    $manufacturers = (clone $baseQuery)
        ->select('manufacturer', \DB::raw('count(*) as count'))
        ->groupBy('manufacturer')
        ->pluck('count', 'manufacturer');
    $isOrganics = (clone $baseQuery)
        ->select('is_organic', \DB::raw('count(*) as count'))
        ->groupBy('is_organic')
        ->pluck('count', 'is_organic');
    $inStocks = (clone $baseQuery)
        ->select('in_stock', \DB::raw('count(*) as count'))
        ->groupBy('in_stock')
        ->pluck('count', 'in_stock');
    $storageTemps = (clone $baseQuery)
        ->select('storage_temp', \DB::raw('count(*) as count'))
        ->groupBy('storage_temp')
        ->pluck('count', 'storage_temp');
    $expirationDates = (clone $baseQuery)
        ->select('expiration_date', \DB::raw('count(*) as count'))
        ->groupBy('expiration_date')
        ->pluck('count', 'expiration_date');
    $priceRanges = [
        '0-50' => (clone $baseQuery)->whereBetween('price', [0, 50])->count(),
        '50-100' => (clone $baseQuery)->whereBetween('price', [50.01, 100])->count(),
        '100-200' => (clone $baseQuery)->whereBetween('price', [100.01, 200])->count(),
        '200+' => (clone $baseQuery)->where('price', '>', 200)->count(),
    ];

    return view('category', compact(
        'categories', 'products', 'category',
        'fatContents', 'volumes', 'manufacturers', 'isOrganics', 'inStocks', 'storageTemps', 'expirationDates', 'priceRanges'
    ));
})->name('category.all');

// Customer page
Route::get('/customer', function (\Illuminate\Http\Request $request) {
    $customerId = $request->session()->get('customer_id');
    if (!$customerId) {
        return redirect('/')->with('error', 'Будь ласка, авторизуйтесь');
    }
    
    $customer = \App\Models\Customer::findOrFail($customerId);
    
    // Створюємо демо-дані для замовлень (тимчасово)
    $orders = collect([
        (object)[
            'id' => 1001,
            'total' => 145.50,
            'status' => 'Завершено',
            'created_at' => \Carbon\Carbon::now()->subDays(5)
        ],
        (object)[
            'id' => 1002,
            'total' => 278.75,
            'status' => 'Очікується',
            'created_at' => \Carbon\Carbon::now()->subDays(2)
        ],
        (object)[
            'id' => 1003,
            'total' => 93.20,
            'status' => 'Відправлено',
            'created_at' => \Carbon\Carbon::now()->subDays(1)
        ]
    ]);
    
    return view('customer', compact('customer', 'orders'));
})->name('customer.profile');

// Customer registration
Route::post('/register-customer', [\App\Http\Controllers\CustomerAuthController::class, 'register'])->name('customer.register');

// Customer login
Route::post('/login-customer', [\App\Http\Controllers\CustomerAuthController::class, 'login'])->name('customer.login');

// Customer logout
Route::post('/logout-customer', [\App\Http\Controllers\CustomerAuthController::class, 'logout'])->name('customer.logout');

// Search page
Route::get('/search', [\App\Http\Controllers\ProductController::class, 'search'])->name('search');

