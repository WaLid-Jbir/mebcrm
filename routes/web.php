<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\DocusignController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/admin/login');

Route::get('fill-data-pdf', [PDFController::class,'index']);


Route::post('/docusign/send-email', [DocusignController::class, 'index']);



Route::get('docusign',[DocusignController::class, 'index'])->name('docusign')->middleware(config('filament.middleware.auth'));
Route::get('connect-docusign',[DocusignController::class, 'connectDocusign'])->name('connect.docusign');
Route::get('docusign/callback',[DocusignController::class,'callback'])->name('docusign.callback');
Route::get('sign-document',[DocusignController::class,'signDocument'])->name('docusign.sign');

Route::get('docusign/login',[DocusignController::class,'login'])->name('docusign.login');
