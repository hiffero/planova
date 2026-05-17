<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\CafeController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Route utama aplikasi PLANOVA dengan dukungan autentikasi & role-based access
|
*/

// ─── PUBLIC ROUTES ─────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ─── AUTHENTICATION ROUTES (Laravel Breeze/Jetstream Compatible) ─
// Pastikan file auth.php memiliki route logout dengan method POST
require __DIR__.'/auth.php';

// ─── USER ROUTES (Authenticated Only) ──────────────────────────
Route::middleware(['auth'])->group(function () {
    
    // Dashboard User
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ─── RESERVATION ROUTES ─────────────────────────────────────
    // Create & Store (Form reservasi baru)
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    
    // Index (Riwayat reservasi user)
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    
    // Show & Edit (Opsional - untuk detail & edit reservasi)
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    
    // ─── LOGOUT ROUTE (Explicit) ────────────────────────────────
    // Jika auth.php tidak memiliki route logout, ini sebagai fallback
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

// ─── GUEST ROUTES (Only for non-authenticated) ─────────────────
Route::middleware(['guest'])->group(function () {
    // Bisa tambahkan route khusus guest jika diperlukan
    // Contoh: landing page dengan CTA login/register
});

// ─── ADMIN ROUTES (Authenticated + Admin Role) ─────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // ─── CAFE MANAGEMENT ───────────────────────────────────────
    Route::resource('cafes', CafeController::class)->parameters([
        'cafes' => 'cafe' // Optional: custom parameter name
    ]);

    // Tambahkan route ini
    Route::get('/cafes/{cafe}/menu', function(\App\Models\Cafe $cafe) {
        $cafe->load('menus');
        return view('reservations.show-menu', compact('cafe'));
    })->name('cafes.menu');
    
    // ─── MENU MANAGEMENT ───────────────────────────────────────
    Route::resource('menus', MenuController::class)->parameters([
        'menus' => 'menu'
    ]);
    
    // ─── RESERVATION MANAGEMENT (Admin) ────────────────────────
// ─── RESERVATION MANAGEMENT (Admin) ────────────────────────
    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::patch('/reservations/{reservation}/status', [AdminReservationController::class, 'updateStatus'])->name('reservations.update-status');    
    // ─── ADDITIONAL ADMIN ROUTES (Opsional) ────────────────────
    // Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    // Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
});

// ─── API ROUTES PREFIX (Opsional untuk future expansion) ───────
// Route::prefix('api')->name('api.')->group(function () {
//     // API endpoints untuk mobile app / third-party integration
// });

// ─── FALLBACK ROUTE (404 Handling) ─────────────────────────────
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::post('/admin/cafes/bulk-delete', [CafeController::class, 'bulkDelete'])
     ->name('admin.cafes.bulk-delete')
     ->middleware(['auth', 'admin']);