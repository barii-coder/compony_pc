<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use \App\Livewire\Admin\Home\Index;

Route::get('/', Index::class)->name('home');

Route::get('/submit', \App\Livewire\Admin\Support\Index::class);
// Login
Route::get('/login', fn() => view('login'))->name('login');
Route::get('/view-user-chats',\App\Livewire\Home\UserChats::class);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Register
Route::get('/register', fn() => view('register'))->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Dashboard
Route::get('/dashboard', Index::class)->middleware('auth');


// daii

Route::get('test', \App\Livewire\TestForm::class)->name('test-form');

Route::post('test/upload', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'images' => ['required', 'array'],
        'images.*' => ['image', 'max:10240'],
        'name' => ['nullable', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:5000'],
    ], [
        'images.required' => 'حداقل یک عکس انتخاب کنید.',
        'images.*.image' => 'هر فایل باید تصویر باشد.',
        'images.*.max' => 'حداکثر حجم هر فایل ۱۰ مگابایت است.',
    ]);
    $dir = public_path('test-paste');
//    $dir = base_path('../public_html/test-paste'); on c-panel
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $urls = [];
    foreach ($request->file('images') as $file) {
        $filename = uniqid('img_').'.'.$file->getClientOriginalExtension();
        $file->move($dir, $filename);
        $urls[] = asset('test-paste/'.$filename);
    }

    return response()->json([
        'urls' => $urls,
        'name' => $request->input('name'),
        'description' => $request->input('description'),
    ]);
})->name('test.upload');
