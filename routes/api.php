<?php

use App\Http\Controllers\GetMasyarakatBerita;
use App\Http\Controllers\SyncSamarindaApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('sync-samarinda-api', SyncSamarindaApi::class);
Route::get('masyarakat/berita', GetMasyarakatBerita::class);
