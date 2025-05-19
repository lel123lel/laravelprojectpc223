<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LostController;
use App\Models\LostItem;

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
