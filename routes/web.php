<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocaleController;

// CRUDs CONTROLLERS
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SonDriveVehicleController;
use App\Models\Customer;
use App\Models\Repair;

// Locale Switch Route
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
use App\Http\Controllers\DashboardController;

// dashboard pages
Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/dashboard', function () {
    $monthlyIncome = array_fill(0, 12, 0);
    $monthlyTarget = 5000000; // Meta mensual en pesos.

        $completedThisMonth = Repair::query()
            ->where('status', 'completada')
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->sum('total_cost');

        $completedToday = Repair::query()
            ->where('status', 'completada')
            ->whereDate('date', today())
            ->sum('total_cost');

        $monthlyProgress = $monthlyTarget > 0
            ? min(($completedThisMonth / $monthlyTarget) * 100, 100)
            : 0;

    Repair::query()
        ->whereYear('date', now()->year)
        ->get(['date', 'total_cost'])
        ->each(function ($repair) use (&$monthlyIncome) {
            $monthlyIncome[$repair->date->month - 1] += (float) $repair->total_cost;
        });

        // Para estadísticas de reparaciones mensuales
        $monthlyRepairCounts = array_fill(0, 12, 0);

    Repair::query()
        ->whereYear('date', now()->year)
        ->get(['date'])
        ->each(function ($repair) use (&$monthlyRepairCounts) {
            $monthlyRepairCounts[$repair->date->month - 1]++;
        });
    
    
        $recentRepairs = Repair::with(['vehicle.customer', 'mechanic'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

    return view('pages.dashboard.index', [
        'title' => 'Panel del taller',
        'customerCount' => Customer::count(),
        'monthlyIncome' => $monthlyIncome,

        // Para el Target mensual y progreso
        'monthlyTarget' => $monthlyTarget,
        'completedThisMonth' => $completedThisMonth,
        'completedToday' => $completedToday,
        'monthlyProgress' => $monthlyProgress,

        // Para el listado de reparaciones recientes
        'repairCount' => Repair::count(),


        // Para estadísticas de reparaciones mensuales
        'monthlyRepairCounts' => $monthlyRepairCounts,

        // Para el listado de reparaciones recientes
        'recentRepairs' => $recentRepairs,

        
    ]);
})->middleware('auth')->name('dashboard');

// calender pages
Route::get('/calendar', function () {
    return view('pages.calender', ['title' => 'Calendar']);
})->middleware(['auth', 'role:admin,mecanico'])->name('calendar');

// profile pages
Route::get('/profile', function () {
    return view('pages.profile', ['title' => 'Profile']);
})->name('profile');

// form pages
Route::get('/form-elements', function () {
    return view('pages.form.form-elements', ['title' => 'Form Elements']);
})->name('form-elements');

// tables pages
Route::get('/basic-tables', function () {
    return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
})->name('basic-tables');




// pages

Route::get('/blank', function () {
    return view('pages.blank', ['title' => 'Blank']);
})->name('blank');

// error pages
Route::get('/error-404', function () {
    return view('pages.errors.error-404', ['title' => 'Error 404']);
})->name('error-404');

// chart pages
Route::get('/line-chart', function () {
    return view('pages.chart.line-chart', ['title' => 'Line Chart']);
})->name('line-chart');

Route::get('/bar-chart', function () {
    return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
})->name('bar-chart');

// ui elements pages
Route::get('/alerts', function () {
    return view('pages.ui-elements.alerts', ['title' => 'Alerts']);
})->name('alerts');

Route::get('/avatars', function () {
    return view('pages.ui-elements.avatars', ['title' => 'Avatars']);
})->name('avatars');

Route::get('/badge', function () {
    return view('pages.ui-elements.badges', ['title' => 'Badges']);
})->name('badges');

Route::get('/buttons', function () {
    return view('pages.ui-elements.buttons', ['title' => 'Buttons']);
})->name('buttons');

Route::get('/image', function () {
    return view('pages.ui-elements.images', ['title' => 'Images']);
})->name('images');

Route::get('/videos', function () {
    return view('pages.ui-elements.videos', ['title' => 'Videos']);
})->name('videos');


// Authenticated Routes (cualquier rol)

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notificaciones
    Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
});

// Rutas del taller: solo admin y mecánico
Route::middleware(['auth', 'role:admin,mecanico'])->group(function () {
    // Customer Routes
    Route::get('/customers', [CustomerController::class, 'index'])
        ->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])
        ->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])
        ->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])
        ->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])
        ->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])
        ->name('customers.destroy');

    // Vehicle Routes
    Route::resource('vehicles', VehicleController::class);

    // Repair Routes
    Route::resource('repairs', RepairController::class)
        ->except(['show']);
    Route::get('/repairs/{repair}/pdf', [RepairController::class, 'downloadPdf'])
    ->name('repairs.pdf');

    // Calendar Events Route
    Route::get('/calendar/events', [RepairController::class, 'calendarEvents'])
    ->name('calendar.events');
});

// Administración: solo admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/sondrive/vehicles', [SonDriveVehicleController::class, 'index'])
        ->name('sondrive.vehicles.index');
    Route::get('/sondrive/vehicles/create', [SonDriveVehicleController::class, 'create'])
        ->name('sondrive.vehicles.create');
    Route::post('/sondrive/vehicles', [SonDriveVehicleController::class, 'store'])
        ->name('sondrive.vehicles.store');
    Route::get('/sondrive/vehicles/{vehicle}/edit', [SonDriveVehicleController::class, 'edit'])
        ->whereNumber('vehicle')
        ->name('sondrive.vehicles.edit');
    Route::put('/sondrive/vehicles/{vehicle}', [SonDriveVehicleController::class, 'update'])
        ->whereNumber('vehicle')
        ->name('sondrive.vehicles.update');
    Route::delete('/sondrive/vehicles/{vehicle}', [SonDriveVehicleController::class, 'destroy'])
        ->whereNumber('vehicle')
        ->name('sondrive.vehicles.destroy');

    // User Routes
    Route::resource('users', UserController::class)
        ->except(['show']);
});

require __DIR__.'/auth.php';
