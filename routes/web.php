<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    ProjectController,
    TaskController,
    TimeTrackingController,
    InvoiceController,
    NotificationController,
    PortfolioController,
    BlogController,
    ServiceController,
    AnalyticsController,
    Auth\LoginController,
    Auth\RegisterController,
    ProfileController,
    AdminController,
    ContactController,
    DashboardController,
    ContactInfoController,
    DevisController,
    ClientDevisController,
    PaymentController,
    PayPalController,
    MeetingController,
    ChatController,
    TestimonialController,
    ProjectTimelineController
};
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Client\ClientTestimonialController;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

// ------------------ ROUTES PUBLIQUES ------------------

// Page d'accueil
Route::get('/', function () {
    $teamMembers = User::where('Role', '!=', 'Client')->get();
    $services = Service::where('IsAvailable', true)->get();
    return view('welcome', compact('teamMembers', 'services'));
})->name('default');

// Page de contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Authentification
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Blogs publics
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');

// Autres pages publiques
Route::get('/home', [DashboardController::class, 'index'])->name('home');
Route::get('/temoignages', [TestimonialController::class, 'index'])->name('testimonials');
Route::get('/portPub', [PortfolioController::class, 'affiche'])->name('portfolios.public');
Route::get('/tags', [PortfolioController::class, 'getTags'])->name('tags.autocomplete');

// ------------------ ROUTES PROTÉGÉES ------------------

Route::middleware(['auth'])->group(function () {

    // Dashboard contact info
    Route::get('/dashboard/contact-info/edit', [ContactInfoController::class, 'edit'])->name('dashboard.contact-info.edit');
    Route::put('/dashboard/contact-info/update', [ContactInfoController::class, 'update'])->name('dashboard.contact-info.update');

    // Users, Tasks, Time tracking
    Route::resource('users', UserController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('time-tracking', TimeTrackingController::class);

    // Projets
    Route::resource('projects', ProjectController::class);
    Route::get('/client/request', [ProjectController::class, 'requestForm'])->name('client.request');
    Route::post('/client/request', [ProjectController::class, 'submitRequest'])->name('client.submitRequest');
    Route::get('/client/services', [ProjectController::class, 'clientServices'])->name('client.services');
    Route::post('/projects/{id}/cancel', [ProjectController::class, 'cancelProject'])->name('projects.cancel');

    // Devis
    Route::resource('devis', DevisController::class);
    Route::post('/devis/{devis}/action', [DevisController::class, 'action'])->name('client.devis.action');

    // Devis côté client
    Route::prefix('client/devis')->name('client.devis.')->group(function () {
        Route::get('/', [ClientDevisController::class, 'index'])->name('index');
        Route::get('/{devis}', [ClientDevisController::class, 'show'])->name('show');
        Route::post('/{devis}/accept', [ClientDevisController::class, 'accept'])->name('accept');
        Route::post('/{devis}/reject', [ClientDevisController::class, 'reject'])->name('reject');
        Route::post('/{devis}/request-changes', [ClientDevisController::class, 'requestChanges'])->name('requestChanges');
        Route::get('/{devis}/download', [ClientDevisController::class, 'download'])->name('download');
    });

    // Paiement
    Route::get('/paypal/payment/{invoiceId}', [PayPalController::class, 'showPaymentForm'])->name('paypal.show');
    Route::post('/paypal/create/{invoiceId}', [PayPalController::class, 'createPayment'])->name('paypal.create');
    Route::post('/paypal/process/{invoiceId}', [PayPalController::class, 'processPayment'])->name('paypal.process');
    Route::get('/payment/success', [PayPalController::class, 'paymentSuccess'])->name('payment.success');

    Route::get('/payment/{invoiceId}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment/process/{invoiceId}', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/bro', [PaymentController::class, 'paymentSuccess']);

    // Factures
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/create/{projectID}', [InvoiceController::class, 'create'])->name('create');
        Route::post('/', [InvoiceController::class, 'store'])->name('store');
        Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('edit');
        Route::get('/{id}/download', [InvoiceController::class, 'download'])->name('download');
        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
        Route::put('/{invoice}', [InvoiceController::class, 'update'])->name('update');
        Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('destroy');
    });

    // Notifications
    Route::resource('notifications', NotificationController::class)->except(['edit', 'update']);
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Portfolios, Témoignages, Services
    Route::resource('portfolios', PortfolioController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('services', ServiceController::class);

    // Analytics
    Route::post('/analytics/log', [AnalyticsController::class, 'logAnalytics']);
    Route::get('/analytics/user/{userId}', [AnalyticsController::class, 'getAnalyticsByUser']);
    Route::get('/analytics/device/{deviceType}', [AnalyticsController::class, 'getAnalyticsByDeviceType']);
    Route::get('/analytics/{analyticsId}/user', [AnalyticsController::class, 'getAnalyticsWithUser']);
    Route::delete('/analytics/{analyticsId}', [AnalyticsController::class, 'deleteAnalytics']);

    // Routes du tableau de bord
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes Admin
    Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/projects', [AdminController::class, 'index'])->name('admin.projects');
        Route::get('/projects/{id}/show', [AdminController::class, 'show'])->name('admin.projects.show');
        Route::post('/projects/{id}/approve', [AdminController::class, 'approveProject'])->name('admin.projects.approve');
        Route::post('/projects/{id}/reject', [AdminController::class, 'rejectProject'])->name('admin.projects.reject');
        Route::post('/projects/{id}/assign', [AdminController::class, 'assignProject'])->name('admin.projects.assign');
    });

    // Routes Client
    Route::middleware(['auth', \App\Http\Middleware\ClientAccessMiddleware::class])->prefix('client')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('client.dashboard');
        Route::get('/projects', [ProjectController::class, 'index'])->name('client.projects');
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('client.request');
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('client.invoices');
    });

    // Routes Freelancer
    Route::middleware(['auth', \App\Http\Middleware\FreelancerMiddleware::class])->prefix('freelancer')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('freelancer.dashboard');
        Route::get('/tasks', [TaskController::class, 'index'])->name('freelancer.tasks');
        Route::get('/projects', [ProjectController::class, 'index'])->name('freelancer.projects');
    });

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Messages clients
    Route::get('/clientslist', [ContactController::class, 'listclient'])->name('clients.index');

    // Chat
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/list', [ChatController::class, 'list'])->name('chat.list');
    Route::get('/chat/{clientId}', [ChatController::class, 'show'])->name('chat.show');

    // Blog (admin)
    Route::get('/test', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::get('/dashboard/blogs', [BlogController::class, 'dashboard'])->name('blogs.dashboard');
    Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');

    // Meetings
    Route::get('/schedule', [MeetingController::class, 'index'])->name('meetings.index');
    Route::get('/meetings', [MeetingController::class, 'create'])->name('meetings.create');
    Route::post('/meetings', [MeetingController::class, 'store'])->name('meetings.store');
    Route::get('/meetings/show', [MeetingController::class, 'show'])->name('meetings.show');
    Route::put('/meetings', [MeetingController::class, 'edit'])->name('meetings.edit');
    Route::delete('/meetings', [MeetingController::class, 'destroy'])->name('meetings.destroy');
    Route::get('/meetings/calendar', [MeetingController::class, 'calendar'])->name('meetings.calendar');
    Route::get('/meetings/calendar-data', [MeetingController::class, 'calendarData']);

    // Routes pour le chat
    Route::get('/projects/{projectId}/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/projects/{projectId}/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::post('/chat/messages/{messageId}/read', [ChatController::class, 'markAsRead'])->name('chat.markAsRead');

    // Timeline du projet
    Route::get('/projects/{projectId}/timeline', [ProjectTimelineController::class, 'show'])->name('projects.timeline');

    // Routes pour les tâches
    Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}', [App\Http\Controllers\TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{id}/edit', [App\Http\Controllers\TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{id}', [App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{id}/assign', [App\Http\Controllers\TaskController::class, 'assignTask'])->name('tasks.assign');
    Route::put('/tasks/{id}/status', [App\Http\Controllers\TaskController::class, 'updateStatus'])->name('tasks.status');
    Route::get('/my-tasks', [App\Http\Controllers\TaskController::class, 'developerTasks'])->name('tasks.developer');

    // Time Tracking Routes
    Route::get('/time-tracking', [TimeTrackingController::class, 'index'])->name('time-tracking.index');
    Route::post('/time-tracking/start', [TimeTrackingController::class, 'start'])->name('time-tracking.start');
    Route::post('/time-tracking/stop', [TimeTrackingController::class, 'stop'])->name('time-tracking.stop');
    Route::get('/time-tracking/active-session', [TimeTrackingController::class, 'getActiveSession'])->name('time-tracking.active-session');
});

// Routes pour les témoignages clients
Route::middleware(['auth', \App\Http\Middleware\ClientAccessMiddleware::class])->prefix('client')->name('client.')->group(function () {
    Route::get('/testimonials', [ClientTestimonialController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials', [ClientTestimonialController::class, 'store'])->name('testimonials.store');
    Route::get('/testimonials/create', [ClientTestimonialController::class, 'create'])->name('testimonials.create');
    Route::get('/testimonials/{testimonial}', [ClientTestimonialController::class, 'show'])->name('testimonials.show');
    Route::get('/testimonials/{testimonial}/edit', [ClientTestimonialController::class, 'edit'])->name('testimonials.edit');
    Route::put('/testimonials/{testimonial}', [ClientTestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [ClientTestimonialController::class, 'destroy'])->name('testimonials.destroy');
});

// Routes pour la gestion des témoignages (admin)
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials.index');
    Route::get('/testimonials/pending', [AdminTestimonialController::class, 'pending'])->name('testimonials.pending');
    Route::post('/testimonials/{testimonial}/approve', [AdminTestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::post('/testimonials/{testimonial}/reject', [AdminTestimonialController::class, 'reject'])->name('testimonials.reject');
    Route::delete('/testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');
});


