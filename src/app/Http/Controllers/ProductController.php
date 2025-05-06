<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
    
    /**
     * Search for products with filters and sorting
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $categoryId = $request->input('category');
        $sort = $request->input('sort', 'relevance');
        $inStock = $request->has('in_stock');
        
        // Start with a base query
        $productsQuery = Product::query();
        
        // Apply search query if provided
        if ($query) {
            // Розбиваємо пошуковий запит на окремі слова для кращого пошуку
            $searchTerms = explode(' ', mb_strtolower($query));
            
            $productsQuery->where(function (Builder $queryBuilder) use ($searchTerms, $query) {
                // Пошук по повному запиту в різних полях
                $queryBuilder->where('name', 'ilike', "%{$query}%")
                    ->orWhere('description', 'ilike', "%{$query}%")
                    ->orWhere('manufacturer', 'ilike', "%{$query}%");
                
                // Додатковий пошук по кожному окремому слову
                foreach ($searchTerms as $term) {
                    if (mb_strlen($term) >= 3) { // Ігноруємо короткі слова (менше 3 символів)
                        $queryBuilder->orWhere('name', 'ilike', "%{$term}%")
                            ->orWhere('description', 'ilike', "%{$term}%")
                            ->orWhere('manufacturer', 'ilike', "%{$term}%");
                    }
                }
            });
        }
        
        // Filter by category if provided
        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }
        
        // Filter by stock availability if requested
        if ($inStock) {
            $productsQuery->where('in_stock', true);
        }
        
        // Apply sorting
        switch ($sort) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $productsQuery->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $productsQuery->orderBy('name', 'desc');
                break;
            case 'relevance':
            default:
                if ($query) {
                    // Покращена логіка сортування за релевантністю
                    // Використовуємо PostgreSQL case-insensitive пошук (ilike)
                    $productsQuery->orderByRaw("
                        CASE 
                            WHEN name ILIKE ? THEN 1
                            WHEN name ILIKE ? THEN 2
                            WHEN name ILIKE ? THEN 3
                            WHEN manufacturer ILIKE ? THEN 4
                            WHEN description ILIKE ? THEN 5
                            ELSE 6
                        END",
                        [
                            $query,               // Точний збіг
                            $query . '%',         // Починається з
                            '%' . $query . '%',   // Містить в назві
                            '%' . $query . '%',   // Містить в виробнику
                            '%' . $query . '%',   // Містить в описі
                        ]
                    );
                } else {
                    $productsQuery->latest(); // Default to newest first
                }
                break;
        }
        
        // Get products with pagination
        $products = $productsQuery->with('category')->paginate(12);
        
        // Get all categories for the filter dropdown
        $categories = Category::orderBy('name')->get();
        
        return view('search', compact('products', 'categories'));
    }
}
