<?php

use App\Livewire\Home;
use App\Livewire\IdCart;
use App\Livewire\Invitation;
use App\Livewire\Profile;
use App\Livewire\Signout;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class);
Route::get('signout', Signout::class);
Route::get('/id', IdCart::class);
Route::middleware(['throttle:50,1'])->group(function () {    
    Route::get('/i/{code}', Invitation::class);
    Route::get('profile', Profile::class);
});
