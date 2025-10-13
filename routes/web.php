<?php

use App\Livewire\Home;
use App\Livewire\Invitation;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class);
Route::get('/i/{code}', Invitation::class);
