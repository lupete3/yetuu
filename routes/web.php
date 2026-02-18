<?php

use App\Http\Controllers\AccompaniementController;
use App\Http\Controllers\AdvisoryController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\ClimateDataController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CropManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\FarmConversionController;
use App\Http\Controllers\FarmerAccompaniementController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\FarmLabourController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\FieldVisitController;
use App\Http\Controllers\GeolocationController;
use App\Http\Controllers\GroupementController;
use App\Http\Controllers\HarvestController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RiskAssessmentController;
use App\Http\Controllers\SeedDistributionsController;
use App\Http\Controllers\SeedVarietieController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SowingRecordController;
use App\Http\Controllers\TerritoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Farmer;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified']);

//Route::post('/weather/fetch', [WeatherController::class, 'fetchWeather'])->name('weather.fetch');
Route::get('/api/weather', [DashboardController::class, 'getWeather'])->name('api.weather');



//Routes for super-admin
Route::middleware(['super-admin'])->group(function () {

    // Gestion des utilisateurs
    Route::resource('/users', UserController::class);

    Route::resource('/farmlabours', FarmLabourController::class);
    Route::get('/farmlabours-export-excel', [FarmLabourController::class, 'getfarmlaboursData'])->name('farmlabours.export_excel');
    Route::get('farmlabours-export-pdf', [FarmLabourController::class, 'print'])->name('farmlabours.print');

    Route::resource('/farmconversions', FarmConversionController::class);
    Route::get('/farmconversions-export-excel', [FarmConversionController::class, 'getfarmconversionData'])->name('farmconversions.export_excel');
    Route::get('farmconversions-export-pdf', [FarmConversionController::class, 'print'])->name('farmconversions.print');

    // Gestion des cultures
    Route::resource('/crop-management', CropManagementController::class);
    Route::get('/crop-management-export-excel', [CropManagementController::class, 'getCropData'])->name('crop-management.export_excel');
    Route::get('crop-management-export-pdf', [CropManagementController::class, 'print'])->name('crop-management.print');

    // Gestion des visites de champs
    Route::resource('/field_visits', FieldVisitController::class);
    Route::post('/field-visits/{id}/remove-photo', [FieldVisitController::class, 'removePhoto'])->name('field_visits.remove_photo');

    // Gestion des semis
    Route::resource('/sowing-records', SowingRecordController::class);

    // Gestion des régions
    Route::resource('/regions', RegionController::class);

    // Gestion des transactions
    Route::resource('/transactions', TransactionController::class);

    // Gestion des paiements
    Route::resource('/payments', PaymentController::class);

    // Gestion des conseils agricoles
    Route::resource('/advisories', AdvisoryController::class);

    // Gestion des informations climatiques
    Route::resource('/climates', ClimateDataController::class);

    // Gestion des alertes
    Route::resource('/alerts', AlertController::class);

    // Gestion des évaluations des risques
    Route::resource('/risk_assessments', RiskAssessmentController::class);

    // Gestion des semences (Seed Distribution)
    Route::resource('/seeds-distribution', SeedDistributionsController::class);

    // Gestion des semences (Seed Varietie)
    Route::resource('/seeds-varietie', SeedVarietieController::class);

    // Gestion des inventaires
    Route::resource('/inventories', InventoryController::class);

    // Gestion des produits
    Route::resource('/products', ProductController::class);

    // Gestion des récoltes et des transferts de produits
    Route::resource('/harvests', HarvestController::class);

    Route::resource('/geolocations', GeolocationController::class);

    // Gestion des pays
    Route::resource('countries', CountryController::class);

    // Gestion des provinces
    Route::resource('provinces', ProvinceController::class);

    // Gestion des territoires
    Route::resource('territories', TerritoryController::class);

    // Gestion des groupements
    Route::resource('localities', GroupementController::class);

    // Gestion des accompagnement
    Route::resource('accompaniements', AccompaniementController::class);

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

});

// Routes for user
Route::middleware(['field_staff'])->group(function () {

    // Gestion des agriculteurs
    Route::resource('/farmers', FarmerController::class);
    Route::get('farmer-export-excel', [FarmerController::class, 'getFarmersData'])->name('farmers.export_excel');
    Route::get('farmer-export-pdf', [FarmerController::class, 'print'])->name('farmers.print');
    Route::get('getFarmer/{farmer}', [FarmerController::class, 'getFarmer'])->name('getFarmerById');
    Route::get('getProvinces/{country}', [ProvinceController::class, 'getProvinces'])->name('getProvincesByCountry');
    Route::get('getTerritories/{province}', [TerritoryController::class, 'getTerritories'])->name('getTerritoriesByProvince');
    Route::get('getLocalities/{locality}', [GroupementController::class, 'getLocalities'])->name('getLocalitesByTerritory');

    // Gestion des champs
    Route::resource('/farms', FarmController::class);
    Route::get('/farm/maps', [FarmController::class, 'showAllMap'])->name('farms.map');
    Route::post('/farms/{id}/remove-document', [FarmController::class, 'removeDocument'])->name('farms.remove_document');
    Route::get('/farm-export-excel', [FarmController::class, 'getFarmsData'])->name('farms.export_excel');
    Route::get('farm-export-pdf', [FarmController::class, 'print'])->name('farms.print');

    // Gestion des champs
    Route::resource('/fields', FieldController::class);
    Route::get('/field/maps', [FieldController::class, 'showAllMap'])->name('fields.map');
    Route::get('/field-export-excel', [FieldController::class, 'getFieldsData'])->name('fields.export_excel');
    Route::get('field-export-pdf', [FieldController::class, 'print'])->name('fields.print');

    // Gestion des cultures
    Route::resource('/crop-management', CropManagementController::class);
    Route::get('/crop-management-export-excel', [CropManagementController::class, 'getCropData'])->name('crop-management.export_excel');
    Route::get('crop-management-export-pdf', [CropManagementController::class, 'print'])->name('crop-management.print');

    // Gestion des visites de champs
    Route::resource('/field_visits', FieldVisitController::class);
    Route::post('/field-visits/{id}/remove-photo', [FieldVisitController::class, 'removePhoto'])->name('field_visits.remove_photo');

    // Gestion des semis
    Route::resource('/sowing-records', SowingRecordController::class);

    Route::resource('farmer-accompaniements', FarmerAccompaniementController::class);
    Route::get('/farmer-accompaniements-export-excel', [FarmerAccompaniementController::class, 'exportToExcel'])->name('farmaccompaniement.export-excel');
    Route::get('/farmer-accompaniements-generate-pdf', [FarmerAccompaniementController::class, 'generatePdf'])->name('farmer-accompaniements.generate_pdf');

});

// Routes pour admin et field_staff
Route::middleware(['admin_staff'])->group(function () {

});

Route::middleware(['auth'])->group(function () {
    // Routes réservées au super-admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route to 404 page not found
Route::fallback(function () {
    $viewData['title'] = 'Error 404';
    return view('404')->with('viewData', $viewData);
});

require __DIR__ . '/auth.php';
