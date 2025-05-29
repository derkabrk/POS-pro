<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\ProductVariant;

Route::get('/product/{product}/variants', function ($productId) {
    $variants = ProductVariant::with('subVariants')
        ->whereHas('products', function($q) use ($productId) {
            $q->where('products.id', $productId);
        })
        ->get();
    return response()->json($variants);
});
