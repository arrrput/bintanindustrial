<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminPanelController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ApplicantCmsController;
use App\Http\Controllers\Admin\BieUnifiedCmsController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\OssCmsController;
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
| Public pages (navbar: Home, Profile, OSS, Blog, Career)
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [Controller::class, 'index'])->name('home');

// Profile video streamed through Laravel so HTTP Range requests (seeking) work on every server,
// including `php artisan serve`, which ignores Range for static files.
Route::get('/video/profile', fn () => response()->file(public_path('assets/vid/biieprovid.mp4'), [
    'Content-Type' => 'video/mp4',
    'Cache-Control' => 'public, max-age=604800',
]))->name('video.profile');
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

// Links (Linktree-style page, linked from footer > Follow Us)
Route::view('/links', 'links')->name('links');

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

// Access per module is permission-based (see App\Support\CmsPermissions); the IT role has every permission.
Route::prefix('cms')->name('cms.')->middleware(['auth', 'cms.access'])->group(function () {
    Route::view('/', 'cms.dashboard')->name('dashboard');
    Route::post('section-settings', [SectionSettingController::class, 'update'])->name('section-settings.update');

    // Recruitment
    Route::resource('careers', CareerController::class)->middleware('permission:careers.manage');
    Route::controller(ApplicantCmsController::class)->prefix('applicants')->name('applicants.')
        ->middleware('permission:applicants.manage')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('{applicant}', 'show')->name('show');
            Route::put('{applicant}/status', 'updateStatus')->name('update-status');
            Route::delete('{applicant}', 'destroy')->name('destroy');
        });

    // Home
    Route::middleware('permission:home.manage')->group(function () {
        Route::get('home', [HomeCmsController::class, 'index'])->name('home.index');
        Route::post('testimonials/bulk-destroy', [TestimonialController::class, 'bulkDestroy'])->name('testimonials.bulk-destroy');
        Route::post('tenants/bulk-destroy', [TenantLogoController::class, 'bulkDestroy'])->name('tenants.bulk-destroy');
        Route::resource('testimonials', TestimonialController::class)->except(['index']);
        Route::resource('tenants', TenantLogoController::class)->except(['show']);
    });

    // Profiles (Bintan Island, Business Opportunity) & OSS (Service Suite, Facilities).
    // "bies" items are shared with Home > Our Industrial Estate; BieController checks the permission per item.
    Route::get('profiles', [BieUnifiedCmsController::class, 'index'])->name('profiles.index')->middleware('permission:profiles.manage');
    Route::get('oss', [OssCmsController::class, 'index'])->name('oss.index')->middleware('permission:oss.manage');
    Route::permanentRedirect('bie-page', '/cms/profiles');
    Route::post('bies/reorder', [BieController::class, 'reorder'])->name('bies.reorder')->middleware('permission:profiles.manage|oss.manage|home.manage');
    Route::resource('bies', BieController::class)->except(['show'])->middleware('permission:profiles.manage|oss.manage|home.manage');

    // Blog (articles + Beyond The Workplace programs)
    Route::resource('blogs', BlogController::class)->middleware('permission:blog.manage');
    Route::resource('programs', ProgramController::class)->middleware('permission:programs.manage');

    // Admin panel
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminPanelController::class, 'index'])->name('admin.index')->middleware('permission:users.manage|roles.manage');
        Route::resource('users', UserController::class)->except(['show'])->middleware('permission:users.manage');
        Route::resource('roles', RoleController::class)->except(['show'])->middleware('permission:roles.manage');
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:roles.manage');
        Route::put('permissions', [PermissionController::class, 'update'])->name('permissions.update')->middleware('permission:roles.manage');
    });
    Route::get('logs', [ActivityLogController::class, 'index'])->name('logs.index')->middleware('permission:activity-logs.view');
});
