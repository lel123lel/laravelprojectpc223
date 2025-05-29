<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LostController;
use App\Models\LostItem;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $lostItems = LostItem::all(); // Retrieve all lost items
    return view('landing', compact('lostItems'));
});

Route::get('/lost', [LostController::class, 'index'])->name('lost.index');
Route::get('/lost/create', [LostController::class, 'create'])->name('lost.create');
Route::post('/lost', [LostController::class, 'store'])->name('lost.store');
Route::get('/lost/{id}', [LostController::class, 'show'])->name('lost.show');
Route::get('/lost/{id}/edit', [LostController::class, 'edit'])->name('lost.edit');
Route::put('/lost/{id}', [LostController::class, 'update'])->name('lost.update');
Route::delete('/lost/{id}', [LostController::class, 'destroy'])->name('lost.destroy');
Route::post('/lost/{id}/verify-reference', [LostController::class, 'verifyReference'])->name('lost.verifyReference');
Route::post('/lost/{id}/verify-delete-reference', [LostController::class, 'verifyDeleteReference'])->name('lost.verifyDeleteReference');
Route::post('/lost/{id}/mark-found', [LostController::class, 'markAsFound'])->name('lost.markFound');
Route::post('/lost/{id}/ajax-mark-found', [LostController::class, 'ajaxMarkAsFound'])->name('lost.ajaxMarkFound');

// Admin panel route (protected, now uses controller for search)
Route::get('/admin', [App\Http\Controllers\LostController::class, 'admin'])->middleware('auth')->name('admin');

// Found Items History route (protected)
Route::get('/found-history', function () {
    // You should fetch found items from your model/table here
    $foundItems = []; // Replace with actual query, e.g., FoundItem::all()
    return view('found-history', compact('foundItems'));
})->middleware('auth')->name('found.history');

// After login, redirect to admin panel
Route::get('/home', function () {
    return redirect()->route('admin');
});

Auth::routes();
