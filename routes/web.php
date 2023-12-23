<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.add_tickets');
})->name('add_tickets');

Route::post('/tickets', [TicketController::class, 'processTickets'])->name('process_tickets');
Route::get('/tickets-lot', [TicketController::class, 'lot_tickets'])->name('lot_tickets');
Route::get('/download-tickets/{title}', [TicketController::class, 'downloadTickets'])->name('download_tickets');
