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
    return view('pages.new_ticket');
})->name('add_tickets');

Route::get('/list-tickets', [TicketController::class, 'listTickets'])->name('list_tickets');
Route::get('/download-ticket/{ticket}', [TicketController::class, 'downloadTicket'])->name('download_ticket');
Route::post('/store-ticket', [TicketController::class, 'storeTicket'])->name('create_ticket');
