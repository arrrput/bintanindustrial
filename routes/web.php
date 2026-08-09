<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LifeController;
use App\Http\Controllers\BieController;
use App\Http\Controllers\SectionSettingController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TenantLogoController;
use App\Http\Controllers\HomeCmsController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Public\CareerController as PublicCareerController;

Route::get('/', [Controller::class, 'index'])->name('home');

Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/blog/{slug}', [BlogController::class, 'show']);

// ======================================================= //
// 1. RUTE LOGIN & LOGOUT                                  //
// ======================================================= //
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// ======================================================= //
// 2. RUTE CMS (DIKUNCI DENGAN MIDDLEWARE 'AUTH')          //
// ======================================================= //
Route::prefix('cms')->name('cms.')->middleware(['auth', 'role:HRGA|BDD|CRS|IT'])->group(function () {

    Route::get('/', function () {
        return view('cms.dashboard');
    })->name('dashboard');

    Route::resource('careers', CareerController::class)->middleware('role:HRGA|BDD|CRS|IT');
    Route::get('applicants', [\App\Http\Controllers\Admin\ApplicantCmsController::class, 'index'])->name('applicants.index')->middleware('role:HRGA|BDD|CRS|IT');
    Route::get('applicants/{applicant}', [\App\Http\Controllers\Admin\ApplicantCmsController::class, 'show'])->name('applicants.show')->middleware('role:HRGA|BDD|CRS|IT');
    Route::put('applicants/{applicant}/status', [\App\Http\Controllers\Admin\ApplicantCmsController::class, 'updateStatus'])->name('applicants.update-status')->middleware('role:HRGA|BDD|CRS|IT');
    Route::delete('applicants/{applicant}', [\App\Http\Controllers\Admin\ApplicantCmsController::class, 'destroy'])->name('applicants.destroy')->middleware('role:HRGA|BDD|CRS|IT');
    Route::resource('blogs', BlogController::class)->middleware('role:BDD|CRS|IT');
    Route::resource('lives', LifeController::class)->middleware('role:BDD|CRS|IT');
    Route::resource('bies', BieController::class)->middleware('role:BDD|CRS|IT');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->middleware('role:IT');
    Route::get('logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('logs.index')->middleware('role:IT');
    Route::post('section-settings', [SectionSettingController::class, 'update'])->name('section-settings.update');

    // Unified Home Management
    Route::get('home', [HomeCmsController::class, 'index'])->name('home.index')->middleware('role:BDD|CRS|IT');
    Route::resource('testimonials', TestimonialController::class)->except(['index'])->middleware('role:BDD|CRS|IT');
    Route::resource('tenants', TenantLogoController::class)->only(['store', 'destroy'])->middleware('role:BDD|CRS|IT');

    // Unified BIE Page Management
    Route::get('bie-page', [\App\Http\Controllers\Admin\BieUnifiedCmsController::class, 'index'])->name('bie-page.index')->middleware('role:BDD|CRS|IT');
});


// ======================================================= //
//      RUTE FRONTEND LAINNYA                              //
// ======================================================= //
Route::redirect('/bintan', '/bie', 301);
Route::redirect('/work', '/bie', 301);
Route::get('/bie', [\App\Http\Controllers\Public\BiePageController::class, 'index'])->name('bie.unified');
Route::get('/life', [LifeController::class, 'publicIndex']);

// ======================================================= //
//    RUTE CAREERS PUBLIK (DINAMIS DARI DATABASE)          //
// ======================================================= //
Route::get('/careers', [PublicCareerController::class, 'index']);
Route::get('/careers/{slug}', [PublicCareerController::class, 'show'])->name('careers.detail');

// Multi-step Application Routes
Route::get('/careers/{slug}/apply', [\App\Http\Controllers\Public\ApplicantController::class, 'showEmailForm'])->name('careers.apply.email');
Route::post('/careers/{slug}/apply/send-otp', [\App\Http\Controllers\Public\ApplicantController::class, 'sendOtp'])->name('careers.apply.send-otp')->middleware('throttle:5,1');
Route::get('/careers/{slug}/apply/verify', [\App\Http\Controllers\Public\ApplicantController::class, 'showOtpForm'])->name('careers.apply.otp');
Route::post('/careers/{slug}/apply/verify', [\App\Http\Controllers\Public\ApplicantController::class, 'verifyOtp'])->name('careers.apply.verify')->middleware('throttle:10,1');
Route::get('/careers/{slug}/apply/form', [\App\Http\Controllers\Public\ApplicantController::class, 'showApplyForm'])->name('careers.apply');
Route::post('/careers/{slug}/apply/form', [\App\Http\Controllers\Public\ApplicantController::class, 'store'])->name('careers.apply.post');

Route::get('/blogs', [BlogController::class, 'publicIndex'])->name('blogs');

// ======================================================= //
//                      RUTE FACTORY                       //
// ======================================================= //
Route::get('/factory/type-a', function () {
    return view('factories.type-a');
});

Route::get('/factory/type-b', function () {
    return view('factories.type-b');
});

Route::get('/factory/type-c', function () {
    return view('factories.type-c');
});

Route::get('/factory/custom', function () {
    return view('experiments.3d-scroll');
});

Route::get('/factory/custom-details', function () {
    return view('factories.custom-build');
});

Route::get('/factory/simulation', function () {
    return view('experiments.3d-simulation');
});
