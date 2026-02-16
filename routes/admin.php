<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\MajorController;
use App\Http\Controllers\admin\DoctorController;
use App\Http\Controllers\admin\BookingController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\auth\LoginController;
use App\Http\Controllers\admin\ScheduleController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\PatientController;
use App\Http\Controllers\admin\ReceptionistController;
use App\Http\Controllers\admin\InvoiceController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\profileController;
use App\Http\Controllers\admin\DoctorDashboardController;

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',

] , function() {

    // Guest
    Route::group([
        'middleware' => ['guest'],
        'controller' => LoginController::class,
    ],
    function() {
        Route::get('/login', 'loginPage')->name('loginPage');
        Route::post('/login', 'login')->name('login');
    }
    );

    // Auth
    Route::group([
        'middleware' => ['auth', 'checkIsAdmin']
    ],
    function() {
    
    Route::get('', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // Majors
    Route::get('/majors', [MajorController::class, 'index'])->name('major.index');
    Route::get('/majors/create', [MajorController::class, 'create'])->name('major.create');
    Route::post('/majors/store', [MajorController::class, 'store'])->name('major.store');
    Route::get('/majors/edit/{major}', [MajorController::class, 'edit'])->name('major.edit');
    Route::put('/majors/update/{major}', [MajorController::class, 'update'])->name('major.update');
    Route::delete('/majors/delete/{major}', [MajorController::class, 'destroy'])->name('major.destroy');

    // Doctors
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctor.create');
    Route::post('/doctors/store', [DoctorController::class, 'store'])->name('doctor.store');
    Route::get('/doctors/edit/{doctor}', [DoctorController::class, 'edit'])->name('doctor.edit');
    Route::put('/doctors/update/{doctor}', [DoctorController::class, 'update'])->name('doctor.update');
    Route::get('/doctors/show/{doctor}', [DoctorController::class, 'show'])->name('doctor.show');
    Route::delete('/doctors/delete/{doctor}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
    Route::get('/doctors/trashed', [DoctorController::class, 'trashed'])->name('doctor.trashed');
    Route::patch('/doctors/{doctor}/restore', [DoctorController::class, 'restore'])->name('doctor.restore');
    // doctor info
    Route::get('/doctors/info/{doctor}', [DoctorController::class, 'info'])->name('doctor.info');
    // Doctor Dashboard Routes
    Route::get('/doctors/my-schedule', [DoctorDashboardController::class, 'mySchedule'])->name('doctor.mySchedule'); 
    Route::get('/doctors/my-bookings', [DoctorDashboardController::class, 'myBookings'])->name('doctor.myBookings'); 
    Route::get('/doctors/my-patients', [DoctorDashboardController::class, 'myPatients'])->name('doctor.myPatients'); 
    Route::get('/doctors/my-invoices', [DoctorDashboardController::class, 'myInvoices'])->name('doctor.myInvoices'); 
    Route::get('/doctor/dashboard', [DoctorDashboardController::class, 'dashboard'])->name('doctor.dashboard');
    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('booking.index');
    Route::delete('/bookings/delete/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');
    Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{id}/update', [BookingController::class, 'update'])->name('booking.update');
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/users/store', [UserController::class,'store'])->name('user.store');
    Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // Profile
    Route::get('/profile/admin', [profileController::class, 'adminProfile'])->name('profile.admin');
    Route::put('/profile/admin', [profileController::class, 'updateAdminProfile'])->name('profile.updateAdmin');
    Route::get('/profile/doctor', [profileController::class, 'doctorProfile'])->name('profile.doctor');
    Route::put('/profile/doctor', [profileController::class, 'updateDoctorProfile'])->name('profile.updateDoctor');
    Route::get('/profile/receptionist', [profileController::class, 'receptionistProfile'])->name('profile.receptionist');
    Route::put('/profile/receptionist', [profileController::class, 'updateReceptionistProfile'])->name('profile.updateReceptionist');

    // contacts 
    Route::get('/contacts', [ContactController::class, 'index'])->name('contact.index');
    Route::delete('/contacts/delete/{contact}', [ContactController::class, 'destroy'])->name('contact.destroy');

    // schedule
    Route::resource('schedule', ScheduleController::class);
    // Services
    Route::resource('service', ServiceController::class);
    // Patients
    Route::resource('patient', PatientController::class);
    // Receptionists
    Route::resource('receptionist', ReceptionistController::class);
    // roles and permissions
    Route::resource('role', RoleController::class);
    // Invoices
    Route::resource('invoice', InvoiceController::class);
    Route::get('invoice/{invoice}/print', [InvoiceController::class,'printInvoice'])->name('invoice.print');
    Route::patch('invoices/{invoice}/toggle-status', 
        [InvoiceController::class, 'toggleStatus']
    )->name('invoice.toggleStatus');

     // Settings
     Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
     Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    }
    );
});