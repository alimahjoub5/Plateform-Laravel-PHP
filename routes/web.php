<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeTrackingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

// Routes d'authentification
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('time-tracking', TimeTrackingController::class);
    Route::resource('invoices', InvoiceController::class);
//-----------------------------------------------------------------------------------------------
// Routes pour les notifications
Route::resource('notifications', NotificationController::class)->except(['edit', 'update']);
Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
//-----------------------------------------------------------------------------------------------
    Route::resource('portfolio', PortfolioController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('analytics', AnalyticsController::class);

    //-----------------------------------------------------------
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('auth')->group(function () {
    // Route pour la page de l'administrateur
    Route::get('/admin/projects', [AdminController::class, 'index'])->name('admin.projects');
    Route::get('/admin/projects/{id}/show', [AdminController::class, 'show'])->name('admin.projects.show'); // Ajouter {id}

    // Routes pour les opérations de l'administrateur
    Route::post('/admin/projects/{id}/approve', [AdminController::class, 'approveProject'])->name('admin.projects.approve');
    Route::post('/admin/projects/{id}/reject', [AdminController::class, 'rejectProject'])->name('admin.projects.reject');
    Route::post('/admin/projects/{id}/assign', [AdminController::class, 'assignProject'])->name('admin.projects.assign');
});


Route::middleware('auth')->group(function () {
        // Routes CRUD pour les projets
        Route::resource('projects', ProjectController::class);
        // Routes supplémentaires
        Route::get('/client/request', [ProjectController::class, 'requestForm'])->name('client.request');
        Route::post('/client/request', [ProjectController::class, 'submitRequest'])->name('client.submitRequest');
        // Route pour afficher les services demandés par le client
        Route::get('/client/services', [ProjectController::class, 'clientServices'])->name('client.services');
        Route::post('/projects/{id}/cancel', [ProjectController::class, 'cancelProject'])->name('projects.cancel');
});    

Route::get('/', function () {
    return view('welcome');
})->name('default');;
Route::get('/temoignages', function () {
    return view('testimonials');
})->name('testimonials');

// Routes publiques
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/home')->name('home');
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    Route::get('/test', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::get('/dashboard/blogs', [BlogController::class, 'dashboard'])->name('blogs.dashboard');
    Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
});