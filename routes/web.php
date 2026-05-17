<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\{
    DashboardController,
};

use App\Http\Controllers\superadmin\{
    DashboardSuperAdminController,
    ApiWhatsappController,
    ManageTestimoniController,
    ManagePelangganController,
    ProfilController as ProfilSuperAdminController,
    BrandController,
    InformasiController,
    PaketHajiController,
    JadwalKeberangkatanController,
    PertanyaanUmumController,
    CalonJemaahController,
    UserJemaahController,
    JadwalManasikController,
};

use App\Http\Controllers\auth\{
    LoginController,
    RegisterController,
    GoogleController,
    ForgotPasswordController,
    ActivationController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/run-superadmin', function () {
    Artisan::call('db:seed', [
        '--class' => 'SuperadminSeeder'
    ]);

    return "SuperAdminSeeder has been create successfully!";
});

// Manual
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/activation', [ActivationController::class, 'showActivationForm'])->name('activation.form')->middleware('auth');
Route::post('/activation', [ActivationController::class, 'activate'])->name('activation.submit')->middleware('auth');

Route::get('/', [App\Http\Controllers\user\LandingController::class, 'index'])->name('home');
Route::get('/paket-kami', [App\Http\Controllers\user\LandingController::class, 'paket'])->name('user.paket');
Route::get('/paket-kami/{id}', [App\Http\Controllers\user\LandingController::class, 'paketDetail'])->name('user.paket.detail');
Route::get('/artikel', [App\Http\Controllers\user\LandingController::class, 'informasi'])->name('user.informasi');
Route::get('/artikel/{id}', [App\Http\Controllers\user\LandingController::class, 'informasiDetail'])->name('user.informasi.detail');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/info-manasik', [App\Http\Controllers\user\LandingController::class, 'jadwalManasik'])->name('user.jadwal-manasik');
    Route::get('/info-manasik/{id}', [App\Http\Controllers\user\LandingController::class, 'jadwalManasikDetail'])->name('user.jadwal-manasik.detail');
    Route::get('/profil', [App\Http\Controllers\user\ProfileController::class, 'index'])->name('user.profil');
    Route::put('/profil/update', [App\Http\Controllers\user\ProfileController::class, 'update'])->name('user.profil.update');
});

// Chat Bot API
Route::get('/api/faqs', [App\Http\Controllers\user\ChatBotController::class, 'getFaqs']);
Route::post('/api/chat', [App\Http\Controllers\user\ChatBotController::class, 'sendMessage']);

Route::group(['middleware' => ['role:superadmin']], function () {
    Route::get('/profil-superadmin', [ProfilSuperAdminController::class, 'index'])->name('profil-superadmin');
    Route::put('/profil-superadmin/update', [ProfilSuperAdminController::class, 'update'])->name('profil-superadmin.update');
    Route::get('/dashboard-superadmin', [DashboardSuperAdminController::class, 'index'])->name('dashboard-superadmin');

    Route::post('informasi/upload-image', [InformasiController::class, 'uploadImage'])->name('informasi.upload.image');
    Route::resource('informasi', InformasiController::class);
    Route::resource('paket-haji', PaketHajiController::class);
    Route::resource('jadwal-keberangkatan', JadwalKeberangkatanController::class);
    Route::resource('pertanyaan', PertanyaanUmumController::class);
    Route::resource('calon-jemaah', CalonJemaahController::class);
    Route::resource('jadwal-manasik', JadwalManasikController::class);
    Route::get('user-jemaah', [UserJemaahController::class, 'index'])->name('user-jemaah.index');
    Route::post('user-jemaah/{user}/generate-code', [UserJemaahController::class, 'generateCode'])->name('user-jemaah.generateCode');
    Route::post('user-jemaah/{user}/activate', [UserJemaahController::class, 'activate'])->name('user-jemaah.activate');
});

