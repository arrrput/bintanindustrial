<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ApplicantCmsController;
use App\Http\Controllers\Admin\BieUnifiedCmsController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BieController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeCmsController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\Public\ApplicantController;
use App\Http\Controllers\Public\BiePageController;
use App\Http\Controllers\Public\CareerController as PublicCareerController;
use App\Http\Controllers\SectionSettingController;
use App\Http\Controllers\TenantLogoController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public pages (navbar: Home, Profile, OSS, News, Career)
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [Controller::class, 'index'])->name('home');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

// Profile
Route::get('/profile', [BiePageController::class, 'index'])->name('profile');

// OSS
Route::get('/oss', [ProgramController::class, 'publicIndex'])->name('oss');

// News
Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [BlogController::class, 'publicIndex'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
});

// Career (vacancies + multi-step application)
Route::prefix('career')->name('career.')->group(function () {
    Route::get('/', [PublicCareerController::class, 'index'])->name('index');
    Route::get('/{slug}', [PublicCareerController::class, 'show'])->name('show');

    Route::controller(ApplicantController::class)->prefix('{slug}/apply')->name('apply')->group(function () {
        Route::get('/', 'showEmailForm')->name('.email');
        Route::post('/send-otp', 'sendOtp')->name('.send-otp')->middleware('throttle:5,1');
        Route::get('/verify', 'showOtpForm')->name('.otp');
        Route::post('/verify', 'verifyOtp')->name('.verify')->middleware('throttle:10,1');
        Route::get('/form', 'showApplyForm')->name('');
        Route::post('/form', 'store')->name('.post');
    });
});

// Factory types (linked from Home > Industrial Solutions)
Route::prefix('factory')->group(function () {
    Route::view('/type-a', 'factories.type-a');
    Route::view('/type-b', 'factories.type-b');
    Route::view('/type-c', 'factories.type-c');
    Route::view('/custom', 'experiments.3d-scroll');
    Route::view('/custom-details', 'factories.custom-build');
    Route::view('/simulation', 'experiments.3d-simulation');
});

/*
|--------------------------------------------------------------------------
| Legacy URLs (permanent redirects so old links & SEO keep working)
|--------------------------------------------------------------------------
*/

Route::permanentRedirect('/bie', '/profile');
Route::permanentRedirect('/bintan', '/profile');
Route::permanentRedirect('/work', '/profile');
Route::permanentRedirect('/program', '/oss');
Route::permanentRedirect('/life', '/oss');
Route::permanentRedirect('/blogs', '/news');
Route::permanentRedirect('/blog/{slug}', '/news/{slug}');
Route::permanentRedirect('/careers', '/career');
Route::permanentRedirect('/careers/{path}', '/career/{path}')->where('path', '.*');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login')->middleware('guest');
    Route::post('/login', 'authenticate')->name('login.post')->middleware('guest');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

/*
|--------------------------------------------------------------------------
| CMS (authenticated)
|--------------------------------------------------------------------------
*/

Route::prefix('cms')->name('cms.')->middleware(['auth', 'role:HRGA|BDD|CRS|IT'])->group(function () {
    Route::view('/', 'cms.dashboard')->name('dashboard');
    Route::post('section-settings', [SectionSettingController::class, 'update'])->name('section-settings.update');

    // Career & applicants (HRGA can access)
    Route::resource('careers', CareerController::class);
    Route::controller(ApplicantCmsController::class)->prefix('applicants')->name('applicants.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{applicant}', 'show')->name('show');
        Route::put('{applicant}/status', 'updateStatus')->name('update-status');
        Route::delete('{applicant}', 'destroy')->name('destroy');
    });

    // Website content
    Route::middleware('role:BDD|CRS|IT')->group(function () {
        // Home
        Route::get('home', [HomeCmsController::class, 'index'])->name('home.index');
        Route::post('testimonials/bulk-destroy', [TestimonialController::class, 'bulkDestroy'])->name('testimonials.bulk-destroy');
        Route::post('tenants/bulk-destroy', [TenantLogoController::class, 'bulkDestroy'])->name('tenants.bulk-destroy');
        Route::resource('testimonials', TestimonialController::class)->except(['index']);
        Route::resource('tenants', TenantLogoController::class)->only(['store', 'destroy']);

        // Profile
        Route::get('bie-page', [BieUnifiedCmsController::class, 'index'])->name('bie-page.index');
        Route::resource('bies', BieController::class);

        // OSS
        Route::resource('programs', ProgramController::class);

        // News
        Route::resource('blogs', BlogController::class);
    });

    // System (IT only)
    Route::middleware('role:IT')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('logs', [ActivityLogController::class, 'index'])->name('logs.index');
    });
});
