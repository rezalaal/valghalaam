<?php

use App\Livewire\Invitation;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    Storage::fake('avatars');
});

it('uploads avatar and attaches to user media collection', function () {
    Storage::fake('avatars');

    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('avatar.jpg');

    // ذخیره فایل روی دیسک fake قبل از addMedia
    Storage::disk('avatars')->putFileAs('', $file, $file->hashName());

    Livewire::test(App\Livewire\Invitation::class, ['code' => '1'])
        ->set('user', ['id' => $user->id])
        ->set('avatar', $file);

    // بررسی فایل روی دیسک
    Storage::disk('avatars')->assertExists($file->hashName());

    // بررسی media collection
    $user->refresh();
    expect($user->getMedia('avatar'))->not->toBeEmpty();
});



