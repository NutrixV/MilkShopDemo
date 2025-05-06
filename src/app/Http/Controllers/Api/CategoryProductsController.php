<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryProductsController extends Controller
{
    /**
     * Get all products for a given category
     *
     * @param  Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($categoryId)
    {
        try {
            // Find the category
            $category = Category::find($categoryId);
            
            // If the category is not found, return a 404 with a message
            if (!$category) {
                Log::warning("API: Category with ID {$categoryId} not found");
                return response()->json([
                    'error' => 'Category not found',
                    'category_id' => $categoryId
                ], 404);
            }
            
            // Get all products for the category (without pagination)
            $products = Product::where('category_id', $category->id)->get();
            
            // Check if there are products
            if ($products->isEmpty()) {
                return response()->json([
                    'products' => [],
                    'total' => 0,
                    'category' => [
                        'id' => $category->id,
                        'name' => $category->name
                    ]
                ]);
            }
            
            // Prepare data for the frontend with attribute parsing
            $formattedProducts = $products->map(function ($product) {
                // Extract attributes from the name and other fields
                $fatContent = $this->extractFatContent($product->name);
                $volume = $this->extractVolume($product->name);
                $manufacturer = $this->extractManufacturer($product->name);
                $storageTemp = $this->extractStorageTemp($product->name);
                
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => floatval($product->price),
                    'fat_content' => $fatContent,
                    'volume' => $volume,
                    'manufacturer' => $manufacturer,
                    'storage_temp' => $storageTemp,
                    'is_organic' => $product->is_organic ? '1' : '0',
                    'in_stock' => $product->in_stock ? '1' : '0',
                    'expiration_date' => $product->expiration_date ? date('Y-m-d', strtotime($product->expiration_date)) : null,
                ];
            });
            
            return response()->json([
                'products' => $formattedProducts,
                'total' => $products->count(),
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name
                ]
            ]);
        } catch (\Exception $e) {
            Log::error("API error: " . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while getting products',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Extract fat content from the product name
     * 
     * @param string $name
     * @return string|null
     */
    private function extractFatContent($name)
    {
        if (preg_match('/(\d+\.?\d*)%/', $name, $matches)) {
            return $matches[1];
        }
        return null;
    }
    
    /**
     * Extract volume from the product name
     * 
     * @param string $name
     * @return string|null
     */
    private function extractVolume($name)
    {
        if (preg_match('/(\d+)\s*(мл|ml|л|l)/i', $name, $matches)) {
            $volume = $matches[1];
            $unit = strtolower($matches[2]);
            
            // Convert liters to milliliters
            if ($unit === 'л' || $unit === 'l') {
                $volume = $volume * 1000;
            }
            
            return (string)$volume;
        }
        return null;
    }
    
    /**
     * Extract manufacturer from the product name
     * 
     * @param string $name
     * @return string|null
     */
    private function extractManufacturer($name)
    {
        $manufacturers = ['Молокія', 'Галичина', 'Простоквашино', 'Яготинське'];
        foreach ($manufacturers as $manufacturer) {
            if (strpos($name, $manufacturer) !== false) {
                return $manufacturer;
            }
        }
        return null;
    }
    
    /**
     * Extract storage temperature from the product name
     * 
     * @param string $name
     * @return string|null
     */
    private function extractStorageTemp($name)
    {
        if (preg_match('/(\d+-\d+°C)/', $name, $matches)) {
            return $matches[1];
        }
        return null;
    }
} 