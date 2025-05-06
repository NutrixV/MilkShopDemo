<?php
/**
 * API Routes
 *
 * These routes are loaded by the RouteServiceProvider and all of them will
 * be assigned to the "api" middleware group.
 *
 * @package MilkShopV2
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Маршрут для отримання всіх продуктів у категорії
Route::get('/category/{categoryId}/products', [CategoryProductsController::class, 'index']); 