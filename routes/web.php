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
    TestimonialController,
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
    ChatController
};
use App\Models\User;
use App\Models\Service;

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
Route::get('/home')->name('home');
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

    // Admin
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/projects', [AdminController::class, 'index'])->name('admin.projects');
        Route::get('/projects/{id}/show', [AdminController::class, 'show'])->name('admin.projects.show');
        Route::post('/projects/{id}/approve', [AdminController::class, 'approveProject'])->name('admin.projects.approve');
        Route::post('/projects/{id}/reject', [AdminController::class, 'rejectProject'])->name('admin.projects.reject');
        Route::post('/projects/{id}/assign', [AdminController::class, 'assignProject'])->name('admin.projects.assign');
    });

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Messages clients
    Route::get('/clientslist', [ContactController::class, 'listclient'])->name('clients.index');

    // Chat
    Route::get('/chat/messages', [ChatController::class, 'getMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);

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
});