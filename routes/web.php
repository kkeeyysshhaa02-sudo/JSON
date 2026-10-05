<?php

use App\Http\Controllers\QuoteController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

// CaQuotes Endpoint
Route::get('/', [QuoteController::class, 'index'])->name('quotes.index');
Route::resource('/quotes', QuoteController::class);

// Luscious Recipes Endpoints
Route::get('/resep', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/resep/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/recipes', [RecipeController::class, 'index']);
Route::get('/recipes/{id}', [RecipeController::class, 'show']);
Route::get('/api/recipes', [RecipeController::class, 'apiIndex']);
Route::get('/api/recipes/search', [RecipeController::class, 'search']);
Route::get('/api/recipes/{id}', [RecipeController::class, 'apiShow']);



$produk = [
    [
        "id" => 2,
        "nama" => "Buku lima sekawan",
        "harga" => 50000,
        "stok" => 10,
    ],
    [
        "id" => 3,
        "nama" => "Buku alam baka",
        "harga" => 30000,
        "stok" => 15,
    ],
    [       
        "id" => 4,
        "nama" => "Buku cara menjadi presiden",
        "harga" => 40000,
        "stok" => 20,
    ],
    [
        "id" => 5,
        "nama" => "Buku membuat website",
        "harga" => 120000,
        "stok" => 6,
    ],
    [
        "id" => 6,
        "nama" => "Buku cara jadi sukses",
        "harga" => 160000,
        "stok" => 8,
    ],
    [
        "id" => 7,
        "nama" => "Buku cerita tidur",
        "harga" => 20000,
        "stok" => 12,
    ],
];

Route::get('/produk', function () use ($produk) {
    return response()->json($produk);
});

Route::get('/produk/{id}', function ($id) use ($produk) {
    $item = collect($produk)->firstWhere('id', (int) $id);

    if ($item === null) {
        return response()->json(['message' => 'Produk tidak ditemukan'], 404);
    }

    return response()->json($item);
});


