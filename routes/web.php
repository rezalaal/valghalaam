<?php

use App\Livewire\Home;
use App\Livewire\Invitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class);

Route::middleware(['throttle:50,1'])->group(function () {    
    Route::get('/i/{code}', Invitation::class);
});
