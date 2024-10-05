<?php



use App\Http\Controllers\PedidoController;

Route::get('/', [PedidoController::class, 'index'])->name('pedido.index');
Route::post('/confirmar', [PedidoController::class, 'confirmar'])->name('pedido.confirmar');
Route::post('/actualizar/{id}', [PedidoController::class, 'actualizar'])->name('pedido.actualizar');
Route::post('/eliminar/{id}', [PedidoController::class, 'eliminar'])->name('pedido.eliminar');

