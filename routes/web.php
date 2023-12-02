<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\{CurrencyComponent, ProductComponent, PurchaseComponent, SupplierComponent, TaxComponent, CategoryComponent, NewPurchaseComponent, ShowPurchaseComponent, DashboardComponent};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/inicio', DashboardComponent::class )->name('Inicio');
    Route::get('/monedas', CurrencyComponent::class )->name('Monedas');
    Route::get('/productos', ProductComponent::class )->name('Productos');
    Route::get('/compra', PurchaseComponent::class )->name('Compras');
    Route::get('/proveedores', SupplierComponent::class )->name('Proveedores');
    Route::get('/impuestos', TaxComponent::class )->name('Impuestos');
    Route::get('/categorias', CategoryComponent::class )->name('Categorias');
    Route::get('/nueva_compra', NewPurchaseComponent::class )->name('Nueva Compra');
    Route::get('/mostrar_compra/{id}', ShowPurchaseComponent::class )->name('Mostrar Compra');
    Route::get('/', DashboardComponent::class )->name('Inicio');
});
