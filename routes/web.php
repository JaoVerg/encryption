<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Crypt;

Route::get('/', function () {
        // Redirect authenticated users to the dashboard
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//test encryption
Route::get('/test-encryption', function () {
    // Encryption example
    $password = '12345678';
    $encrypted = 'eyJpdiI6ImsrdEdERHphbmtNTUdHQmd5Zytvb2c9PSIsInZhbHVlIjoiRHhlT2xVajhEc3I1NlUwazNna2lHdz09IiwibWFjIjoiNDFmMThhOTRlZWE3N2E1ZTk5MWEyYjI5ZWM5NDczNTc4MGViMDlkY2NkZGZmNjU1Y2M2YWNkZmNlODA0NDhjZCIsInRhZyI6IiJ9';
    //$encrypted = Crypt::encryptString($password);
    echo("\n");
    echo($encrypted);
    echo("\n");
    // Decryption example
    try {
        $decrypted = Crypt::decryptString($encrypted);
        return "Decrypted password: $decrypted";
    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        return "Error decrypting: " . $e->getMessage();
    }
});


require __DIR__.'/auth.php';
